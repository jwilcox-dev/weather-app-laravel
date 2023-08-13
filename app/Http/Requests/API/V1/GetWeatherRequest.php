<?php

namespace App\Http\Requests\API\V1;

use App\Rules\Postcode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetWeatherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'post_code' => ['required', new Postcode],
        ];
    }

    public function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error Getting Weather',
            'errors' => $validator->errors(),
        ], 422));
    }
}
