<?php

namespace Tests\Feature\Routes\API\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class StoreFavouriteTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $headers;

    public function setUp(): void
    {
        parent::setUp();
        $this->headers = ['Accept' => 'application/json'];
    }

    /** @test */
    public function it_can_store_favourites_for_authenticated_users()
    {
        $user = User::factory()->createOne();

        Sanctum::actingAs($user, ['all']);

        $response = $this->post(route('api.v1.favourites.store'), [
            'post_code' => $this->faker->postcode(),
            'description' => $this->faker->text(60),
        ], $this->headers);

        $response->assertOk();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    /** @test */
    public function it_cannot_store_favourites_for_unauthenticated_users()
    {
        $response = $this->post(route('api.v1.favourites.store'), [
            'post_code' => $this->faker->postcode(),
            'description' => $this->faker->text(60),
        ], $this->headers);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    /** @test */
    public function it_cannot_store_favourites_with_invalid_input()
    {
        $user = User::factory()->createOne();

        Sanctum::actingAs($user, ['all']);

        $response = $this->post(route('api.v1.favourites.store'), [
            'post_code' => $this->faker->postcode(),
        ], $this->headers);

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
        ]);
    }
}