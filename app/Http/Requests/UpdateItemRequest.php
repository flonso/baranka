<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;
use App\Models\Eloquent\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UpdateItemRequest extends BaseFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [
            'name' => [
                'filled',
                'regex:' . RegexHelpers::NAME_REGEX_WITH_NUMBERS
            ],
            'certificateNumber' => [
                'filled'
            ],
            'discoveryPoints' => [
                'integer'
            ],
            'adventurePoints' => [
                'integer'
            ],
            'multiplierIncrement' => [
                'regex:' . RegexHelpers::FLOAT_REGEX
            ],
            'foundByPlayerIds' => [
                'array'
            ]
        ];

        $playerIds = $this->request->get('foundByPlayerIds');

        if (isset($playerIds) && is_array($playerIds)) {
            foreach ($playerIds as $key => $id) {
                $rules["foundByPlayerIds.$key"] = [
                    Rule::exists('players', 'id')->where(function($query) use ($id) {
                        DB::table('players')
                            ->where('code', '=', $id)
                            ->orWhere('id', '=', $id)
                        ;
                    })
                ];
            }
        }

        return $rules;
    }

    public function messages() {
        $messages = [
            'name.filled' => "Le nom de l'objet ne doit pas être vide",
            'name.regex' => "Le nom de l'objet contient des caractères invalides",
            'certificateNumber.filled' => 'Le numéro de certificat ne peut pas être vide',
            'discoveryPoints.integer' => "Les points de découvertes doivent être un nombre entier ('$this->discoveryPoints' reçu)",
            'adventurePoints.integer' => "Les points d'aventure doivent être un nombre entier ('$this->adventurePoints' reçu)",
            'multiplierIncrement.regex' => "L'incrément du multiplicateur de score doit être un nombre entier ou décimal ('$this->multiplierIncrement' reçu)",
        ];

        if (isset($this->foundByPlayerIds) && is_array($this->foundByPlayerIds)) {
            foreach ($this->foundByPlayerIds as $key => $id) {
                $messages["foundByPlayerIds.$key.exists"] = "Il n'y a pas de joueur correspondant à l'identifiant '$id'";
            }
        }

        return $messages;
    }
}