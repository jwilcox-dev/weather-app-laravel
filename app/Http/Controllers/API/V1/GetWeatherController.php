<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\GetLocation;
use App\Actions\GetWeather;
use App\Actions\GetFavourite;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GetWeatherRequest;

class GetWeatherController extends Controller
{
    public function __invoke(GetWeatherRequest $request, GetLocation $getLocation, GetWeather $getWeather, GetFavourite $getFavourite)
    {
        $postCode = $request->validated('post_code');
        $location = $getLocation($postCode);

        if (empty($location)) {
            return response()->noContent();
        };

        $weather = $getWeather($location[0]);

        if (!$weather) {
            return response()->noContent();
        }

        if (!$request->bearerToken()) {
            $favourite = $getFavourite($postCode);
        }

        if ($request->bearerToken()) {
            $favourite = $getFavourite($postCode, $request->bearerToken());
        }

        return response()->json([
            'location' => $location[0],
            'weather' => $weather,
            'favourite' => $favourite,
        ]);
    }
}