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
                'filled',
                'min:1',
                'max:250',
                "regex:" . RegexHelpers::NAME_REGEX
            ],
            'lastName' => [
                'required',
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
            'code' => [
                'min:1',
                'max:250'
            ],
            'teamId' => [
                'required',
                'regex:' . RegexHelpers::INTEGER_REGEX,
                'exists:teams,id'
            ],
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
            'group.string' => "Le groupe doit être une chaîne de caractère",
            'birthDate.date_format' => "La date de naissance doit suivre le format YYYY-MM-DD (ISO)",
            'teamId.exists' => "Il n'y a pas d'équipe portant l'id '$this->teamId'",
            'teamId.regex' => "L'identifiant d'équipe est invalide",
            'regex' => "Le champ ':attribute' contient des caractères invalides"
        ];
    }
}
