<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateUserRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticateUserController extends Controller
{
    public function __invoke(AuthenticateUserRequest $request)
    {
        if (Auth::attempt($request->validated())) {

            $user = User::findOrFail(Auth::user()->id);
            $user->tokens()->delete();

            return response()->json([
                'email' => $user->email,
                'token' => $user->createToken('api', ['all'])->plainTextToken,
                'favourites' => $user->favourites,
            ]);

        }

        return response()->json([
            'message' => 'Invalid Credentials',
        ], 401);
    }
}
