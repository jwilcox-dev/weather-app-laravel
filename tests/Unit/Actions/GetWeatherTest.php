<?php

namespace Tests\Unit\Actions;

use App\Actions\GetWeather;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class GetWeatherTest extends TestCase
{
    use DatabaseTransactions, WithFaker;
    
    private $location;

    public function setUp(): void
    {
        parent::setUp();

        $this->location = [
            'place_id' => 290722375,
            'lat' => '52.81709',
            'lon' => '-2.08738',
        ];
    }

    /** @test */
    public function it_checks_if_the_weather_data_is_already_in_the_cache(): void
    {
        $spy = Cache::spy();
        
        $getWeather = new GetWeather();
        $getWeather($this->location);

        $spy->shouldHaveReceived('has')->once()->with($this->location['place_id']);
    }

    /** @test */
    public function it_returns_weather_data_with_a_valid_latitude_and_longitude(): void
    {
        $getWeather = new GetWeather();
        $result = $getWeather($this->location);

        $this->assertArrayHasKey('current_weather', $result);
    }

    /** @test */
    public function it_caches_weather_data_with_a_valid_latitude_and_longitude(): void
    {
        $spy = Cache::spy();
        
        $getWeather = new GetWeather();
        $getWeather($this->location);

        $spy->shouldHaveReceived('put')->once();
    }

    /** @test */
    public function it_returns_an_empty_array_with_an_invalid_latitude_and_longitude(): void
    {
        $getWeather = new GetWeather();
        $result = $getWeather([
            'place_id' => 290722375,
            'lat' => '95',
            'lon' => '125'
        ]);

        $this->assertEmpty($result);
    }
}