<?php

namespace App\Http\Controllers;

use App\Import\Import;
use Maatwebsite\Excel\Excel;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ActivityImportRequest;

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
     * @param ActivityImportRequest $activityImportRequest
     *
     * @return JsonResponse
     */
    public function uploadRoster(ActivityImportRequest $activityImportRequest): JsonResponse
    {
        $file = public_path('data/CrewConnex.html');
        ( new Import() )->import($file, null, 'Html');

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
