<?php

namespace Tests\Feature\Routes\API\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;

class StoreUserTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $headers;

    public function setUp(): void
    {
        parent::setUp();
        $this->headers = ['Accept' => 'application/json'];
    }

    /** @test */
    public function users_can_register_with_valid_input()
    {
        $response = $this->post(route('api.v1.users.store'), [
            'email' => $this->faker->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ], $this->headers);

        $response->assertOk();
        $response->assertJsonStructure([
            'email',
            'token'
        ]);
    }

    /** @test */
    public function users_cannot_register_with_invalid_input()
    {
        $response = $this->post(route('api.v1.users.store'), [
            'email' => $this->faker->safeEmail(),
            'password' => 'password1',
            'password_confirmation' => 'password2'
        ], $this->headers);

        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    /** @test */
    public function it_does_not_allow_more_than_5_registration_requests_in_1_minute() {

        for ($i = 1; $i<=5; $i++) {
            $this->post(route('api.v1.users.store'));
        }

        $response = $this->post(route('api.v1.users.store'));
        $response->assertTooManyRequests();
    }
}