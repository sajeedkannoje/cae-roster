<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetEventsByDateRangeTest extends TestCase
{
    public function testGetEventsByDateRangeWithValidDateRange()
    {
        $response = $this->postJson(route('activity.get-events-by-date-range'), [
            'from' => '2022-01-01',
            'to'   => '2022-02-01',
        ]);
        $response->assertSuccessful();
    }

    public function testGetEventsByDateRangeWithInvalidDateRange()
    {
        $response = $this->postJson(route('activity.get-events-by-date-range'), [
            'from' => '2022-01-01',
            'to'   => '2021-02-01',
        ]);
        $response->assertJsonValidationErrors(['to', 'from']);
    }
}
