<?php

namespace Tests\Unit\Actions;

use App\Actions\GetFavourite;
use App\Models\Favourite;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;

class GetFavouriteTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function it_returns_is_favourite_as_false_if_there_is_no_bearer_token(): void
    {
        $getFavourite = new GetFavourite();
        $postCode = $this->faker->postcode();

        $result = $getFavourite($postCode);

        $this->assertFalse($result['isFavourite']);
    }

    /** @test */
    public function it_returns_favourite_description_as_false_if_there_is_no_bearer_token(): void
    {
        $getFavourite = new GetFavourite();
        $postCode = $this->faker->postcode();

        $result = $getFavourite($postCode);

        $this->assertFalse($result['favouriteDescription']);
    }

    /** @test */
    public function it_returns_is_favourite_as_false_if_the_bearer_token_is_invalid(): void
    {
        $user = User::factory()->createOne();
        $bearerToken = Str::random(24);
        
        $favourite = Favourite::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $getFavourite = new GetFavourite();

        $result = $getFavourite($favourite->post_code, $bearerToken);

        $this->assertFalse($result['isFavourite']);
    }

    /** @test */
    public function it_returns_favourite_description_as_false_if_the_bearer_token_is_invalid(): void
    {
        $user = User::factory()->createOne();
        $bearerToken = Str::random(24);
        
        $favourite = Favourite::factory()->createOne([
            'user_id' => $user->id,
        ]);
        
        $getFavourite = new GetFavourite();

        $result = $getFavourite($favourite->post_code, $bearerToken);

        $this->assertFalse($result['favouriteDescription']);
    }

    /** @test */
    public function it_returns_is_favourite_as_true_if_the_matching_bearer_token_has_favourited_the_postcode(): void
    {
        $user = User::factory()->createOne();
        $bearerToken = $user->createToken('api', ['all'])->plainTextToken;
        
        $favourite = Favourite::factory()->createOne([
            'user_id' => $user->id,
        ]);

        $getFavourite = new GetFavourite();

        $result = $getFavourite($favourite->post_code, $bearerToken);

        $this->assertTrue($result['isFavourite']);
    }

    /** @test */
    public function it_returns_the_favourite_description_if_the_matching_bearer_token_has_favourited_the_postcode(): void
    {
        $user = User::factory()->createOne();
        $bearerToken = $user->createToken('api', ['all'])->plainTextToken;
        
        $favourite = Favourite::factory()->createOne([
            'user_id' => $user->id,
        ]);
        
        $getFavourite = new GetFavourite();

        $result = $getFavourite($favourite->post_code, $bearerToken);

        $this->assertEquals($favourite->description, $result['favouriteDescription']);
    }
}
