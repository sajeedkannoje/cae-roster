<?php

namespace App\Http\Controllers;

use Exception;
use App\Enum\Platform;
use App\Helper\FileHelper;
use Maatwebsite\Excel\Excel;
use App\Import\ImportManager;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Services\ActivityService;
use App\Http\Requests\DateFilterRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Requests\ActivityImportRequest;

/**
 *
 */
class ActivityController extends Controller
{
    use ActivityService;

    /**
     * @param DateFilterRequest $dateFilterRequest
     *
     * @return JsonResponse
     */
    public function getEventsByDateRange(DateFilterRequest $dateFilterRequest): JsonResponse
    {
        $activityData = $this->getEventsByDateRangBetweenDateRange($dateFilterRequest);

        return $this->respondWithResource(ActivityResource::collection($activityData));
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
        $flightData = $this->fetchFlightsNextWeek();

        return $this->respondWithResource(ActivityResource::collection($flightData));
    }

    /**
     * @return JsonResponse
     */
    public function getFlightsFromLocation(): JsonResponse
    {
        $flightData = $this->fetchFlightsFromLocation();

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
