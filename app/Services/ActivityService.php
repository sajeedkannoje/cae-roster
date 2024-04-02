<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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

    public function fetchFlightsNextWeek()
    {
        // As per the condition, given in the assigment we are considering the current date as the start date of the week
        $currentDate = Carbon::createFromFormat("Y-m-d", "2022-01-14");

        // Calculate the start and end dates of the next week
        $startDate = $currentDate->copy()->startOfWeek()->addWeek()->toDateString();
        $endDate = $currentDate->copy()->endOfWeek()->addWeek()->toDateString();

        // Define the regular expression pattern for flight number
        $pattern = '^[A-Z]{2}\d+$';
        return Activity::where('activity', 'REGEXP', $pattern)
                       ->whereBetween('date', [ $startDate, $endDate ])->get();


    }

}
