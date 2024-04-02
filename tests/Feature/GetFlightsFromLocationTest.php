<?php

namespace Tests\Feature;

use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetFlightsFromLocationTest extends TestCase
{

    public function testGetFlightsFromLocationWithValidLocation()
    {
        $response = $this->postJson(route('flights.from-location'), [
            'location' => Activity::select('from')->first()->from,
        ]);
        $response->assertSuccessful();
    }

    public function testGetFlightsFromLocationWithInvalidLocation()
    {
        $response = $this->postJson(route('flights.from-location'), [
            'location' => 'LAXX',
        ]);
        $response->assertJsonValidationErrors(['location']);
    }
}
