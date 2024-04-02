<?php

namespace App\Http\Controllers;

use Exception;
use App\Enum\Platform;
use App\Helper\FileHelper;
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
        $importInstance = match ( Platform::tryFrom($activityImportRequest->get('platform')) ) {
            Platform::RosterBuster => ImportManager::getInstance()->getImportInstance(Platform::RosterBuster, $activityImportRequest),
            default                => ImportManager::getInstance()->getImportInstance(Platform::RosterBuster, $activityImportRequest),
        };

        if ($activityImportRequest->hasFile('attachment')) {

            $file = FileHelper::uploadFile($activityImportRequest->file('attachment'));
            $importInstance->import($file, null, Excel::XLSX);
            return $this->respondSuccess('Roster uploaded successfully');
        }

        return $this->respondError("File not found");

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
