<?php

namespace App\Actions;

use Laravel\Sanctum\PersonalAccessToken;
use App\Models\User;

class GetFavourite {

    public function __invoke(String $postCode, String | false $bearerToken = false) {

        $isFavourite = false;
        $favouriteDescription = false;

        if ($bearerToken) {

            $token = PersonalAccessToken::findToken($bearerToken);

            if ($token) {
    
                $user = User::find($token->tokenable_id);
                $favourite = $user->favourites->where('post_code', $postCode)->first();
    
                if ($favourite) {
                    $isFavourite = true;
                    $favouriteDescription = $favourite['description'];
                }
                
            }

        }

        return [
            'isFavourite' => $isFavourite,
            'favouriteDescription' => $favouriteDescription
        ];
        
    }
}