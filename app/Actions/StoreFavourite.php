<?php

namespace App\Actions;
use App\Models\Favourite;
use App\Models\User;
use Exception;

class StoreFavourite {

    public function __invoke(array $data, User $user): Favourite | false {

        try {

            $favourite = $user->favourites()->save(Favourite::make($data));
            return $favourite;

        } catch (Exception $e) {

            return false;
            
        }
    }
}