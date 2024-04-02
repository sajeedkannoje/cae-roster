<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetFlightsNextWeekTest extends TestCase
{

    public function testGetFlightsNextWeek()
    {
        $response = $this->getJson(route('flights.next-week'));
        $response->assertSuccessful();
    }
}
