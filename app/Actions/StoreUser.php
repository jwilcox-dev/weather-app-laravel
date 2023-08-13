<?php

namespace App\Actions;
use App\Models\User;
use Exception;

class StoreUser {

    public function __invoke(array $data): User | false {

        try {

            $user = User::create($data);
            return $user;

        } catch (Exception $e) {

            return false;

        } 
    }
}