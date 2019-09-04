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
            'discoveredByPlayerIds' => [
                'array',
            ],
            'adventureCompletedByPlayerIds' => [
                'array'
            ]
        ];

        $playerIds = $this->request->get('discoveredByPlayerIds');

        // TODO: This could probably be optimied into a single query
        if (isset($playerIds) && is_array($playerIds)) {
            foreach ($playerIds as $key => $id) {
                $rules["discoveredByPlayerIds.$key"] = [
                    Rule::exists('players', 'id')->where(function($query) use ($id) {
                        return DB::table('players')
                            ->where('code', '=', $id)
                            ->orWhere('id', '=', $id)
                        ;
                    })
                ];
            }
        }

        $playerIds = $this->request->get('adventureCompletedByPlayerIds');

        // TODO: Make this into a single query ?
        if (isset($playerIds) && is_array($playerIds)) {
            foreach ($playerIds as $key => $id) {
                $rules["adventureCompletedByPlayerIds.$key"] = [
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

        if (isset($this->discoveredByPlayerIds) && is_array($this->discoveredByPlayerIds)) {
            foreach ($this->discoveredByPlayerIds as $key => $id) {
                $messages["discoveredByPlayerIds.$key.exists"] = "Il n'y a pas de joueur correspondant à l'identifiant '$id'";
            }
        }


        if (
            isset($this->adventureCompletedByPlayerIds) &&
            is_array($this->adventureCompletedByPlayerIds)
        ) {
            foreach ($this->adventureCompletedByPlayerIds as $key => $id) {
                $messages["adventureCompletedByPlayerIds.$key.exists"] = "Il n'y a pas de joueur correspondant à l'identifiant '$id'";
            }
        }

        return $messages;
    }
}
