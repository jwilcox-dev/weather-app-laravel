<?php

namespace Tests\Feature\Routes\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;

class AuthenticateUserTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $headers;

    public function setUp(): void
    {
        parent::setUp();
        $this->headers = ['Accept' => 'application/json'];
    }

    /** @test */
    public function users_can_login_with_valid_credentials()
    {
        $user = User::factory()->createOne([
            'password' => 'password'
        ], $this->headers);

        $response = $this->post(route('api.authenticate-user'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'email',
            'token',
            'favourites'
        ]);
    }

    /** @test */
    public function users_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->createOne([
            'password' => 'password'
        ], $this->headers);

        $response = $this->post(route('api.authenticate-user'), [
            'email' => $user->email,
            'password' => 'incorrect',
        ]);

        $response->assertUnauthorized();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    /** @test */
    public function it_does_not_allow_more_than_5_login_requests_in_1_minute() {

        for ($i = 1; $i<=5; $i++) {
            $this->post(route('api.authenticate-user'));
        }

        $response = $this->post(route('api.authenticate-user'));
        $response->assertTooManyRequests();
    }
}