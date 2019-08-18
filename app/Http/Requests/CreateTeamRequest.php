<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;

class CreateTeamRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => [
                'required',
                'regex:' . RegexHelpers::NAME_REGEX
            ],
            'initialScore' => [
                'regex:' . RegexHelpers::INTEGER_REGEX
            ],
            'initialScoreMultiplier' => [
                'regex:' . RegexHelpers::FLOAT_REGEX
            ]
        ];
    }

    public function messages() {
        return [
            'required' => "Le champ ':attribute' est requis",
            'initialScore.regex' => "Le score initial de l'équipe doit être un nombre entier",
            'initialScoreMultiplier.regex' => "Le multiplicateur de score initial de l'équipe doit être un nombre entier ou décimal",
        ];
    }
}
