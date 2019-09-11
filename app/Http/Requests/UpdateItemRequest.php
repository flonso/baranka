<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;
use App\Rules\CustomExists;
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
            'discoveredByPlayerIds' => [
                'array',
                'min:1',
                function($attribute, $value, $fail) {
                    if ($this->item->discovered === true) {
                        $name = $this->item->name;
                        $fail("$name a déjà été découvert(e)");
                    }
                }
            ],
            'adventureCompletedByPlayerIds' => [
                'array',
                'min:1',
                function($attribute, $value, $fail) {
                    if ($this->item->adventureCompleted === true) {
                        $name = $this->item->name;
                        $fail("L'aventure liée à $name est déjà terminée");
                    }
                }
            ]
        ];

        $playerIds = $this->request->get('discoveredByPlayerIds');

        // TODO: This could probably be optimied into a single query
        if (isset($playerIds) && is_array($playerIds)) {
            foreach ($playerIds as $key => $id) {
                $rules["discoveredByPlayerIds.$key"] = [
                    new CustomExists('players', function($query, $value) use ($id) {
                        $query->where('id', '=', $id)->orWhere('code', '=', $id);
                    })
                ];
            }
        }

        $playerIds = $this->request->get('adventureCompletedByPlayerIds');

        // TODO: Make this into a single query ?
        if (isset($playerIds) && is_array($playerIds)) {
            foreach ($playerIds as $key => $id) {
                $rules["adventureCompletedByPlayerIds.$key"] = [
                    new CustomExists('players', function($query, $value) {
                        $query->where('id', '=', $value)->orWhere('code', '=', $value);
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

        if (isset($this->discoveredByPlayerIds) && is_array($this->discoveredByPlayerIds)) {
            foreach ($this->discoveredByPlayerIds as $key => $id) {
                $messages["discoveredByPlayerIds.$key.customExists"] = "Il n'y a pas de joueur correspondant à l'identifiant '$id'";
            }
        }


        if (
            isset($this->adventureCompletedByPlayerIds) &&
            is_array($this->adventureCompletedByPlayerIds)
        ) {
            foreach ($this->adventureCompletedByPlayerIds as $key => $id) {
                $messages["adventureCompletedByPlayerIds.$key.customExists"] = "Il n'y a pas de joueur correspondant à l'identifiant '$id'";
            }
        }

        return $messages;
    }
}
