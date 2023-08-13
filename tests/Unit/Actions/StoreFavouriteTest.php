<?php

namespace Tests\Unit\Actions;

use App\Actions\StoreFavourite;
use App\Models\User;
use App\Models\Favourite;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreFavouriteTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function it_can_store_a_favourite(): void
    {
        $storeFavourite = new StoreFavourite();
        $user = User::factory()->createOne();

        $result = $storeFavourite([
            'post_code' => 'ST18 0WP',
            'description' => 'Stafford Office'
        ], $user);

        $this->assertInstanceOf(Favourite::class, $result);
    }

    /** @test */
    public function it_returns_false_if_the_favourite_data_is_invalid(): void
    {
        $storeFavourite = new StoreFavourite();
        $user = User::factory()->createOne();

        $result = $storeFavourite([
            'post_code' => 'ST18 0WP',
        ], $user);

        $this->assertFalse($result);
    }
}
