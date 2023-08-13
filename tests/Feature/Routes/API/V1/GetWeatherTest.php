<?php

namespace Tests\Feature\Routes\API\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class GetWeatherTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $headers;
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->headers = ['Accept' => 'application/json'];
        $this->user = User::factory()->createOne();
    }

    /** @test */
    public function test_it_can_get_weather_data_for_an_unauthenticated_user(): void
    {
        $data = [
            'post_code' => 'ST18 0WP',
        ];

        $response = $this->get(route('api.v1.get-weather', $data), $this->headers);

        $response->assertOk();
        $response->assertJsonStructure([
            'location',
            'weather',
            'favourite'
        ]);
    }

    /** @test */
    public function test_it_can_get_weather_data_for_an_authenticated_user(): void
    {
        Sanctum::actingAs($this->user, ['all']);

        $data = [
            'post_code' => 'ST18 0WP',
        ];

        $response = $this->get(route('api.v1.get-weather', $data), $this->headers);

        $response->assertOk();
        $response->assertJsonStructure([
            'location',
            'weather',
            'favourite'
        ]);
    }

    /** @test */
    public function it_does_not_allow_more_than_5_get_weather_requests_in_1_minute_for_unauthenticated_users() {

        for ($i = 1; $i<=5; $i++) {
            $this->get(route('api.v1.get-weather'));
        }
        
        $response = $this->get(route('api.v1.get-weather'));
        $response->assertTooManyRequests();
    }

    /** @test */
    public function it_does_not_allow_more_than_25_get_weather_requests_in_1_minute_for_authenticated_users() {

        Sanctum::actingAs($this->user, ['all']);

        for ($i = 1; $i<=25; $i++) {
            $this->get(route('api.v1.get-weather'));
        }
        
        $response = $this->get(route('api.v1.get-weather'));
        $response->assertTooManyRequests();
    }
}