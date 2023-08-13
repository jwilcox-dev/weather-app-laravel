<?php

namespace Tests\Unit\Http\Requests\API\V1;

use Tests\TestCase;
use App\Http\Requests\API\V1\StoreFavouriteRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoreFavouriteRequestTest extends TestCase
{
    /** @test */
    /** @dataProvider provideInvalidData */
    public function test_it_should_fail_validation(array $invalidData): void
    {
        $storeFavouriteRequest = new StoreFavouriteRequest();
        $validator = Validator::make($invalidData, $storeFavouriteRequest->rules());
        $this->assertFalse($validator->passes());
    }

    /** @test */
    /** @dataProvider provideValidData */
    public function test_it_should_pass_validation(array $validData): void
    {
        $storeFavouriteRequest = new StoreFavouriteRequest();
        $validator = Validator::make($validData, $storeFavouriteRequest->rules());
        $this->assertTrue($validator->passes());
    }

    public static function provideInvalidData(): array
    {
        return [
            'Empty' => [
                []
            ],
            'Post Code Missing ' => [
                [
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Post Code Empty' => [
                [
                    'post_code' => '',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Post Code Without Outward and Inward Code' => [
                [
                    'post_code' => 'ST180WP',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Post Code With Short Outward Code' => [
                [
                    'post_code' => 'S 0WP',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Post Code With Long Outward Code' => [
                [
                    'post_code' => 'ST189 0WP',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Post Code With Outward Code Not Starting With Letter' => [
                [
                    'post_code' => '18ST 0WP',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Post Code With Short Inward Code' => [
                [
                    'post_code' => 'ST18 0W',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Post Code With Long Inward Code' => [
                [
                    'post_code' => 'ST18 0WPQ',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Post Code With Inward Code Not Starting With Number' => [
                [
                    'post_code' => 'ST18 WP0',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Description Missing' => [
                [
                    'post_code' => 'ST18 0WP',
                    'notifications' => true,
                ]
            ],
            'Description Empty' => [
                [
                    'post_code' => 'ST18 0WP',
                    'description' => '',
                    'notifications' => true,
                ]
            ],
            'Description Too Long' => [
                [
                    'post_code' => 'ST18 0WP',
                    'description' => Str::random(300),
                    'notifications' => true,
                ]
            ]
        ];
    }

    public static function provideValidData(): array
    {
        return [
            'Valid Favourite - With Notifications' => [
                [
                    'post_code' => 'ST18 0WP',
                    'description' => 'Test Favourite',
                    'notifications' => true,
                ]
            ],
            'Valid Favourite - Without Notifications' => [
                [
                    'post_code' => 'ST18 0WP',
                    'description' => 'Test Favourite',
                ]
            ]
        ];
    }
}
