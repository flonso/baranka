<?php

namespace App\Http\Requests;

use App\Exceptions\ApiExceptions;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

abstract class BaseFormRequest extends FormRequest
{
    /**
     * The action to take upon validation. This method overrides Laravel's default
     * behavior to redirect the user to the previously visited url.
     * Requests inheriting from this class will threrefore always return a JSON response.
     *
     * https://stackoverflow.com/questions/46350307/disable-request-validation-redirect-in-laravel-5-4
     *
     * @param Validator $validator
     * @return Response
     */
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(
            response()->json(
                ApiExceptions::InvalidData(
                    $validator->errors()->toArray()
                )->toArray(),
                400
            )
        );
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();
}
