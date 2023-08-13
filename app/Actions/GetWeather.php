<?php

namespace App\Actions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetWeather {

    public function __invoke(array $location): array | false {
        
        $weatherApi = env('API_WEATHER');
        $placeId = $location['place_id'];

        if (Cache::has($placeId)) {
            return json_decode(Cache::get($placeId), true);
        }

        $response = Http::withoutVerifying()->get($weatherApi, [
            'latitude' => $location['lat'],
            'longitude' => $location['lon'],
            'current_weather' => true
        ]);
        
        if ($response->successful()) {
            
            Cache::put($placeId, json_encode($response->json()), now()->addMinutes(5));
            return $response->json();

        }

        return [];
    }
}