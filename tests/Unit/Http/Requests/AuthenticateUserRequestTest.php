<?php

namespace Tests\Unit\Http\Requests;

use Tests\TestCase;
use App\Http\Requests\AuthenticateUserRequest;
use Illuminate\Support\Facades\Validator;

class AuthenticateUserRequestTest extends TestCase
{
    /** @test */
    /** @dataProvider provideInvalidData */
    public function test_it_should_fail_validation(array $invalidData): void
    {
        $authenticateUserRequest = new AuthenticateUserRequest();
        $validator = Validator::make($invalidData, $authenticateUserRequest->rules());
        $this->assertFalse($validator->passes());
    }

    /** @test */
    /** @dataProvider provideValidData */
    public function test_it_should_pass_validation(array $validData): void
    {
        $authenticateUserRequest = new AuthenticateUserRequest();
        $validator = Validator::make($validData, $authenticateUserRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public static function provideInvalidData(): array
    {
        return [
            'Empty' => [
                []
            ],
            'Email Address Missing ' => [
                [
                    'password' => 'password',
                ]
            ],
            'Email Address Empty ' => [
                [
                    'email' => '',
                    'password' => 'password',
                ]
            ],
            'Email Address Invalid Format' => [
                [
                    'email' => 'invalid-format',
                    'password' => 'password',
                ]
            ],
            'Password Missing ' => [
                [
                    'email' => 'test.user@email.com',
                ]
            ],
            'Password Empty ' => [
                [
                    'email' => 'test.user@email.com',
                    'password' => '',
                ]
            ],
            'Password Short ' => [
                [
                    'email' => 'test.user@email.com',
                    'password' => '123',
                ]
            ],
            'Password Long ' => [
                [
                    'email' => 'test.user@email.com',
                    'password' => '123456789-123456789-123456789',
                ]
            ]
        ];
    }

    public static function provideValidData(): array
    {
        return [
            'Valid User' => [
                [
                    'email' => 'test.user@email.com',
                    'password' => 'password',
                ]
            ],
        ];
    }
}
