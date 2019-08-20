<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;
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
                'regex:' . RegexHelpers::INTEGER_REGEX
            ],
            'level' => [
                'digits_between:1,2',
                'min:1',
            ]
        ];
    }

    public function messages() {
        return [
            'code.min' => "Le code ne doit pas être vide.",
            'code.max' => "Le code ne doit pas excéder 250 caractères",
            'code.unique' => "Le code '$this->code' indiqué est déjà utilisé.",
            'scoreIncrement.regex' => "La valeur d'incrémentation du score doit être un nombre entier ('$this->scoreIncrement' reçu)."
        ];
    }
}
