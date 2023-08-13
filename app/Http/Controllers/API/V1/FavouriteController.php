<?php

namespace App\Http\Controllers\API\V1;

use App\Actions\StoreFavourite;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreFavouriteRequest;

class FavouriteController extends Controller
{
    public function store(StoreFavouriteRequest $request, StoreFavourite $storeFavourite)
    {
        $favourite = $storeFavourite($request->validated(), $request->user());

        if ($favourite) {

            return response()->json([
                'message' => 'Favourite Stored Successfully!',
            ]);

        }

        return response()->json([
            'message' => 'Error Storing Favourite.',
        ], 500);
    }
}