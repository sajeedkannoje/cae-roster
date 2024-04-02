<?php

namespace App\Services;

use App\Models\Activity;
use App\Enum\ActivityEnum;
use Illuminate\Support\Carbon;
use App\Http\Requests\LocationRequest;
use App\Http\Requests\DateFilterRequest;

/**
 *
 */
trait ActivityService
{
    /**
     * @param DateFilterRequest $dateFilterRequest
     *
     * @return mixed
     */
    public function getEventsByDateRangBetweenDateRange(DateFilterRequest $dateFilterRequest): mixed
    {
        // Get the events between the date range
        $from = $dateFilterRequest->get('from');
        $to = $dateFilterRequest->get('to');
        return Activity::whereBetween('date', [ $from, $to ])->get();
    }

    /**
     * @return mixed
     */
    public function fetchFlightsNextWeek(): mixed
    {
        $date = $this->getNextWeekDates();
        return Activity::where('activity', 'REGEXP', '^[A-Z]{2}\d+$')
                       ->whereBetween('date', [ $date['start_date'], $date ['end_date'] ])->get();
    }

    /**
     * @return mixed
     */
    public function fetchStandbyEventsNextWeek(): mixed
    {
        $date = $this->getNextWeekDates();
        // Define the regular expression pattern for standby event
        return Activity::whereActivity(ActivityEnum::StandBy->value)
                       ->whereBetween('date', [ $date['start_date'], $date ['end_date'] ])->get();
    }

    /**
     * @param LocationRequest $locationRequest
     *
     * @return mixed
     */
    public function fetchFlightsFromLocation(LocationRequest $locationRequest): mixed
    {
        return Activity::where('activity', 'REGEXP', '^[A-Z]{2}\d+$')
                       ->whereFrom($locationRequest->get('location'))->get();
    }

    /**
     * @return array
     */
    private function getNextWeekDates(): array
    {
        // As per the condition, given in the assigment we are considering the current date as the start date of the week
        $currentDate = Carbon::createFromFormat("Y-m-d", "2022-01-14");
        return [
            "start_date" => $currentDate->copy()->startOfWeek()->addWeek()->toDateString(),
            "end_date"   => $currentDate->copy()->endOfWeek()->addWeek()->toDateString(),
        ];
    }
}
