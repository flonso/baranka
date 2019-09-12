<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;
use App\Models\Eloquent\Event;
use App\Models\Eloquent\EventType;
use App\Models\Eloquent\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdatePlayerRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'code' => [
                'min:1',
                'max:250',
                'unique:players,code'
            ],
            'scoreIncrement' => [
                'integer'
            ],
            'gainedQuestPoints' => [
                'regex:' . RegexHelpers::FLOAT_REGEX
            ],
            'gainedBoardPoints' => [
                'regex:' . RegexHelpers::FLOAT_REGEX
            ],
            'levelUp' => [
                'boolean',
                function($a, $v, $fail) {
                    $minutes = config('game.level_up_interval_minutes', 0);
                    $lastLevelUpEvent = Event::where('type', '=', EventType::LEVEL_CHANGE)
                        ->orderBy('created_at', 'desc')
                        ->limit(1)
                        ->first();
                    ;

                    // If the value of the event is positive, then it is a level up
                    // otherwise it is a cancellation of the level up and we can proceed
                    $time = $lastLevelUpEvent->created_at->addMinutes($minutes)->toTimeString();
                    if (
                        $lastLevelUpEvent->value > 0 &&
                        $lastLevelUpEvent->created_at->addMinutes($minutes)->greaterThan(now())
                    ) {
                        $fail(
                            "La dernière augmentation de niveau a eu lieu il y a moins de $minutes minutes. La prochaine augmentation possible est à $time"
                        );
                    }
                }
            ],
            'cancelLevelUp' => [
                'boolean',
                function($a, $v, $fail) {
                    if ($this->player->level <= 1) {
                        $fail(
                            $this->player->first_name . "  " . $this->player->last_name . "est déjà au niveau minimum"
                        );
                    }
                }
            ],
            'level' => [
                'digits_between:1,2',
                'min:1',
                'lte:' . config('game.max_level', 0)
            ],
            'firstName' => [
                'filled',
                'min:1',
                'max:250',
                "regex:" . RegexHelpers::NAME_REGEX
            ],
            'lastName' => [
                'filled',
                "regex:" . RegexHelpers::NAME_REGEX
            ],
            'group' => [
                'string',
                'nullable',
                'filled',
            ],
            'birthDate' => [
                'nullable',
                'date_format:Y-m-d' // ISO Date format
            ],
            'comments' => [
                'nullable',
                'string'
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator) {
        $player = $this->route('player');
        $maxLevel = config('game.max_level');

        $validator->after(function($validator) use ($player, $maxLevel) {
            if ($player->level == $maxLevel && $this->has('levelUp')) {
                $validator->errors()->add('levelUp', "Le niveau maximum a été atteint (niveau actuel $player->level)");
            }
        });
    }

    public function messages() {
        return [
            'gainedQuestPoints.regex' => "Les points gagnés doivent être un nombre ('$this->gainedQuestPoints' reçu)",
            'gainedBoardPoints.regex' => "Les points gagnés doivent être un nombre ('$this->gainedBoardPoints' reçu)",
            'level.lt' => "Le niveau doit être inférieur ou égal à 6 ('$this->level' reçu)",
            'code.min' => "Le code ne doit pas être vide.",
            'code.max' => "Le code ne doit pas excéder 250 caractères",
            'code.unique' => "Le code '$this->code' indiqué est déjà utilisé.",
            'scoreIncrement.regex' => "La valeur d'incrémentation du score doit être un nombre entier ('$this->scoreIncrement' reçu).",
            'group.string' => "Le groupe doit être une chaîne de caractère",
            'birthDate.date_format' => "La date de naissance doit suivre le format YYYY-MM-DD (ISO)",
        ];
    }
}
