<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|max:24',
            'password_confirmation' => 'required|string|same:password',
        ];
    }

    public function failedValidation(Validator $validator): HttpResponseException
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Error Storing User',
        ], 422));
    }
}
