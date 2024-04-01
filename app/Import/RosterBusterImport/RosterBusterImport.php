<?php

namespace App\Import\RosterBusterImport;

use App\Import\Import;

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


    /**
     * @param $data
     * @param $index
     *
     * @return mixed
     */
    public function prepareForValidation($data, $index)
    {
        return $this->parseRosterDataToLocalField($data);
//      $data['ciz'] = isset($data['ciz']) ? date("H:i", strtotime($data['ciz'])) : null;
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
    protected function saveDayData(array $dayData)
    {
        if (empty($dayData)) return;

        var_dump($this->currentDayData);
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
