<?php

namespace App\Http\Requests;

use App\Helpers\RegexHelpers;

class StartGameRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'number' => [
                'integer',
                'min:1'
            ]
        ];
    }
}
