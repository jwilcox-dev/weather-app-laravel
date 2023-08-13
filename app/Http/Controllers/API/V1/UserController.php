<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\StoreUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreUserRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function store(StoreUserRequest $request, StoreUser $storeUser): JsonResponse
    {
        $user = $storeUser($request->validated());

        if ($user) {

            $token = $user->createToken('api', ['all']);
            
            return response()->json([
                'email' => $request->email,
                'token' => $token->plainTextToken,
            ]);

        }

        return response()->json([
            'message' => 'Error Storing User.',
        ], 500);
    }
}
