<?php

namespace App\Import\RosterBusterImport;

use Carbon\Carbon;
use App\Import\Import;
use App\Models\Activity;
use App\Http\Requests\ActivityImportRequest;

/**
 *
 */
class RosterBusterImport extends Import
{
    use RosterBusterParser;

    /**
     * @var string
     */
    protected string $lastDate = "";
    /**
     * @var array
     */
    protected array $currentDayData = [];

    protected string $activityDate = "";

    protected string $activityMonthAndYear = "01-2022";

    protected ActivityImportRequest $activityImportRequest;

    public function __construct(ActivityImportRequest $activityImportRequest)
    {
        $this->activityImportRequest = $activityImportRequest;
    }


    /**
     * @param $data
     * @param $index
     *
     * @return mixed
     */
    public function prepareForValidation($data, $index): mixed
    {
        if (!empty($data["date"])) {
            $date = $data["date"] . "-" . $this->activityMonthAndYear;
            $this->activityDate = Carbon::createFromFormat("D d-m-Y", $date)->format("Y-m-d");
        }
        return $this->parseRosterDataToLocalField($data);
    }

    /**
     * @return array
     */
    public function customValidationMessages(): array
    {
        return [];
    }

    /**
     * @param array $dayData
     *
     * @return void
     */
    protected function saveDayData(array $dayData): void
    {
        if (empty($dayData)) return;
        Activity::insert($dayData);
    }

    /**
     * @param array $row
     *
     * @return null
     */
    public function model(array $row): null
    {
        // Check if date has changed
        $currentDate = $row['date'] ?? "";
        if ($currentDate !== "" && $currentDate !== $this->lastDate) {
            if (!empty($this->currentDayData)) {
                $this->saveDayData($this->currentDayData);
                $this->currentDayData = []; // Reset for the new day
            }
            $this->lastDate = $currentDate; // Update the last processed date
        }
        $this->currentDayData[] = $row; // Add current row data to the current day's data

        return null; // Don't create a model instance for each row
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'date'            => 'nullable',
            'revision'        => 'nullable|string',
            'duty_code'       => 'nullable|string',
            'check_in_utc'    => 'nullable',
            'check_out_utc'   => 'nullable',
            'activity'        => 'required|string|max:50',
            'remark'          => 'nullable|string|max:255',
            'from'            => 'required|string|max:50',
            'std_utc'         => 'nullable',
            'to'              => 'required|string|max:50',
            'sta_utc'         => 'nullable',
            'hotel'           => 'nullable|string|max:50',
            'blh'             => 'nullable',
            'flight_time'     => 'nullable',
            'night_time'      => 'nullable',
            'duration'        => 'nullable',
            'ext'             => 'nullable|string',
            'pax_booked'      => 'nullable',
            'ac_registration' => 'nullable|string',
            'crew_id'         => 'nullable|integer',
            'is_imported'     => 'nullable|boolean',
        ];
    }
}
