<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetStandbyEventsNextWeekTest extends TestCase
{

    public function testGetStandbyEventsNextWeek()
    {
        $response = $this->getJson(route('standby.next-week'));
        $response->assertSuccessful();
    }


}
