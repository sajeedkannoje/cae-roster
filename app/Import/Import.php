<?php

namespace App\Import;

use App\Rules\CustomActivityRule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class Import implements ImportInterface
{
    use Importable, SkipsErrors;

    public function model(array $row)
    {

    }

    public function prepareForValidation($data, $index)
    {
        dd($data);
        //Check-in Time (CI)
        $data['c/i(z)'] = isset($data['c/i(z)']) ? date("H:i", strtotime($data['c/i(z)'])) : null;
        //Check-out Time (CO)
        $data['c/o(z)'] = isset($data['c/o(z)']) ? date("H:i", strtotime($data['c/o(z)'])) : null;
        //Scheduled Time Departure (STD)
        $data["std(z)"] = isset($data["std(z)"]) ? date("H:i", strtotime($data["std(z)"])) : null;
        // Scheduled Time Arrival (STA)
        $data["sta(z)"] = isset($data["sta(z)"]) ? date("H:i", strtotime($data["sta(z)"])) : null;

        return $data;
    }

//    public function chunkSize(): int
//    {
//        return 1000;
//    }

    public function rules(): array
    {
        return [
            "activity" => [ 'required', 'string', new CustomActivityRule() ],
            "from"     => [ 'required', 'string' ],
            "to"       => [ 'required', 'string' ],
        ];
    }
}
