<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;
use Illuminate\Validation\Rule;

class CreateItemRequest extends BaseFormRequest
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
                'filled',
                'regex:' . RegexHelpers::NAME_REGEX_WITH_NUMBERS
            ],
            // TODO: Might have to make this optional
            'certificateNumber' => [
                'required'
            ],
            'discoveryPoints' => [
                'required',
                'integer'
            ],
            'adventurePoints' => [
                'required',
                'integer'
            ],
            'multiplierIncrement' => [
                'regex:' . RegexHelpers::FLOAT_REGEX
            ]
        ];
    }

    public function messages() {
        return [
            'required' => "Le champ ':attribute' est requis",
            'name.regex' => "Le nom d'objet contient des caractères invalides",
            'discoveryPoints.integer' => "Les points de découvertes doivent être un nombre entier ('$this->discoveryPoints' reçu)",
            'adventurePoints.integer' => "Les points d'aventure doivent être un nombre entier ('$this->adventurePoints' reçu)",
            'multiplierIncrement.regex' => "L'incrément du multiplicateur de score doit être un nombre entier ou décimal ('$this->multiplierIncrement' reçu)",
        ];
    }
}
