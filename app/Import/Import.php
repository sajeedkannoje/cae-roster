<?php

namespace App\Import;

use App\Rules\CustomActivityRule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class Import implements ImportInterface
{
    use Importable, SkipsErrors, RegistersEventListeners;

    public function model(array $row)
    {
        // TODO: Implement model() method.
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        [
            'activity' => [ 'required', 'string', new CustomActivityRule() ],

        ];
    }
}
