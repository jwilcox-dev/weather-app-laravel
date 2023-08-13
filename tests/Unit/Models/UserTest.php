<?php

namespace Tests\Unit\Models;

use App\Models\Favourite;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function it_can_load_the_favourites_relationship(): void
    {
        $user = User::factory()->createOne();

        $favourite = Favourite::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $this->assertTrue($user->favourites->contains($favourite));
    }

    /** @test */
    public function it_returns_true_if_the_user_has_favourited_a_post_code(): void
    {
        $user = User::factory()->createOne();

        $favourite = Favourite::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $this->assertTrue($user->hasFavourited($favourite->post_code));
    }

    /** @test */
    public function it_returns_false_if_the_user_has_not_favourited_a_post_code(): void
    {
        $user = User::factory()->createOne();
        
        Favourite::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $postCode = $this->faker->postcode();

        $this->assertFalse($user->hasFavourited($postCode));
    }
}
