<?php

namespace Database\Seeders;

use App\Models\Favourite;
use Illuminate\Database\Seeder;

class FavouriteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Favourite::factory()->testFavourite()->createOne();
    }
}
