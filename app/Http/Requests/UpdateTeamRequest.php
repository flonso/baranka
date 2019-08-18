<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;

class UpdateTeamRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'scoreIncrement' => [
                'regex:' . RegexHelpers::INTEGER_REGEX
            ],
            'scoreMultiplierIncrement' => [
                'regex:' . RegexHelpers::FLOAT_REGEX
            ]
        ];
    }

    public function messages() {
        return [
            'scoreIncrement.regex' => "La valeur d'incrémentation du score doit être un nombre entier ($this->scoreIncrement reçu)",
            'scoreMultiplierIncrement' => "La valeur d'incrémentation du multiplicateur de score doit être un nombre entier ou décimal ($this->scoreMultiplierIncrement reçu)"
        ];
    }
}
