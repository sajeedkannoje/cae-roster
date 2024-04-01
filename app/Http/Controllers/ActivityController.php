<?php

namespace App\Http\Controllers;

use Exception;
use App\Enum\Platform;
use Maatwebsite\Excel\Excel;
use App\Import\ImportManager;
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
     * @throws Exception
     */
    public function uploadRoster(ActivityImportRequest $activityImportRequest): JsonResponse
    {
        $importInstance =  ImportManager::getInstance()->getImportInstance(Platform::RosterBuster, $activityImportRequest);

        $file = public_path('data/roster_data.xlsx');

        $importInstance->import($file, null, Excel::XLSX);

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
