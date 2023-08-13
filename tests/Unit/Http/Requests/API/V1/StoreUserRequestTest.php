<?php

namespace Tests\Unit\Http\Requests\API\V1;

use Tests\TestCase;
use App\Http\Requests\API\V1\StoreUserRequest;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Validator;

class StoreUserRequestTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    /** @dataProvider provideInvalidData */
    public function test_it_should_fail_validation(array $invalidData): void
    {
        $this->seed(UserSeeder::class);
        $storeUserRequest = new StoreUserRequest();
        $validator = Validator::make($invalidData, $storeUserRequest->rules());
        $this->assertFalse($validator->passes());
    }

    /** @test */
    /** @dataProvider provideValidData */
    public function test_it_should_pass_validation(array $validData): void
    {
        $storeUserRequest = new StoreUserRequest();
        $validator = Validator::make($validData, $storeUserRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public static function provideInvalidData(): array
    {
        return [
            'Empty' => [
                []
            ],
            'Email Address Missing' => [
                [
                    'password' => 'password',
                    'password_confirmation' => 'password'
                ]
            ],
            'Email Address Empty' => [
                [
                    'email' => '',
                    'password' => 'password',
                    'password_confirmation' => 'password'
                ]
            ],
            'Email Address Invalid Format' => [
                [
                    'email' => 'invalid format',
                    'password' => 'password',
                    'password_confirmation' => 'password'
                ]
            ],
            'Email Address Duplicated' => [
                [
                    'email' => 'test.user@email.com',
                    'password' => 'password',
                    'password_confirmation' => 'password'
                ]
            ],
            'Password Missing' => [
                [
                    'email' => 'new.user@email.com',
                    'password_confirmation' => 'password'
                ]
            ],
            'Password Emtpy' => [
                [
                    '',
                    'email' => 'new.user@email.com',
                    'password_confirmation' => 'password'
                ]
            ],
            'Password Short' => [
                [
                    'email' => 'new.user@email.com',
                    'password' => '123',
                    'password_confirmation' => '123'
                ]
            ],
            'Password Long' => [
                [
                    'email' => 'new.user@email.com',
                    'password' => '123456789-123456789-123456789',
                    'password_confirmation' => '123456789-123456789-123456789',
                ]
            ],
            'Password Confirmation Not Matching' => [
                [
                    'email' => 'new.user@email.com',
                    'password' => 'password',
                    'password_confirmation' => 'not_password',
                ]
            ]
        ];
    }

    public static function provideValidData(): array
    {
        return [
            'Valid User' => [
                [
                    'email' => 'new.user@email.com',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ]
            ]
        ];
    }
}
