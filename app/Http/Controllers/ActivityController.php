<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 *
 */
class ActivityController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function getEventsByDateRange(): JsonResponse
    {
        return $this->respondSuccess('All Events fetched successfully');
    }

    /**
     * @return JsonResponse
     */
    public function uploadRoster(): JsonResponse
    {
        return $this->respondSuccess('Roster uploaded successfully');
    }

    /**
     * @return JsonResponse
     */
    public function getFlightsNextWeek(): JsonResponse
    {
        return $this->respondSuccess('Flights for next week fetched successfully');
    }

    /**
     * @return JsonResponse
     */
    public function getFlightsFromLocation(): JsonResponse
    {
        return $this->respondSuccess('Flights from location fetched successfully');
    }

    /**
     * @return JsonResponse
     */
    public function getStandbyEventsNextWeek(): JsonResponse
    {
        return $this->respondSuccess('Standby events for next week fetched successfully');
    }
}
