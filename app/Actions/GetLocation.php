<?php

namespace App\Actions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetLocation {

    public function __invoke(String $postCode): array | false {

        $geocodeApi = env('API_GEOCODE');

        if (Cache::has($postCode)) {
            return json_decode(Cache::get($postCode), true);
        }

        $response = Http::withoutVerifying()->get($geocodeApi, ['postalcode' => $postCode]);

        if ($response->successful()) {
            
            Cache::put($postCode, json_encode($response->json()), now()->addMinutes(5));
            return $response->json();

        }

        return [];
    }
}