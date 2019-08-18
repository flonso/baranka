<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;

class CreatePlayerRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'firstName' => [
                'required',
                'min:1',
                'max:250',
                // https://www.php.net/manual/fr/regexp.reference.unicode.php
                "regex:" . RegexHelpers::NAME_REGEX
            ],
            'lastName' => [
                'required',
                // https://www.php.net/manual/fr/regexp.reference.unicode.php
                "regex:" . RegexHelpers::NAME_REGEX
            ],
            'code' => [
                'required'
            ],
            'teamId' => [
                'exists:teams,id'
            ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            'required' => "Le champ ':attribute' du joueur est requis.",
            'teamId.exists' => "Il n'y a pas d'équipe portant l'id '$this->teamId'",
            'regex' => "Le champ ':attribute' contient des caractères invalides"
        ];
    }
}
