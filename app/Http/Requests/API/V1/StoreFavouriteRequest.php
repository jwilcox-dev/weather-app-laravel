<?php

namespace App\Http\Requests\API\V1;

use App\Rules\Postcode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreFavouriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_code' => ['required', new Postcode],
            'description' => 'required|string|min:1|max:120',
            'notifications' => 'boolean'
        ];
    }

    public function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error Storing Favourite',
            'errors' => $validator->errors(),
        ], 422));
    }
}
