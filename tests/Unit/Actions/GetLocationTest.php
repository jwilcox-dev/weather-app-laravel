<?php

namespace Tests\Unit\Actions;

use App\Actions\GetLocation;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class GetLocationTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function it_checks_if_the_postcode_data_is_already_in_the_cache(): void
    {
        $spy = Cache::spy();
        
        $getLocation = new GetLocation();
        $postCode = $this->faker->postcode();
        
        $getLocation($postCode);

        $spy->shouldHaveReceived('has')->once()->with($postCode);
    }

    /** @test */
    public function it_returns_location_data_with_a_valid_postcode(): void
    {
        $getLocation = new GetLocation();
        $postCode = $this->faker->postcode();

        $result = $getLocation($postCode);

        $this->assertArrayHasKey('display_name', $result[0]);
    }

    /** @test */
    public function it_caches_location_data_with_a_valid_postcode(): void
    {
        $spy = Cache::spy();
        
        $getLocation = new GetLocation();
        $postCode = $this->faker->postcode();
        
        $getLocation($postCode);

        $spy->shouldHaveReceived('put')->once();
    }

    /** @test */
    public function it_returns_an_empty_array_with_an_invalid_postcode(): void
    {
        $getLocation = new GetLocation();
        $postCode = 'ST23 0FB';

        $result = $getLocation($postCode);

        $this->assertEmpty($result);
    }
}