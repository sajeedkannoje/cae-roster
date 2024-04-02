<?php

namespace App\Import;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

abstract class Import implements ImportInterface
{
    use Importable, SkipsErrors, RegistersEventListeners;

    public function chunkSize(): int
    {
        return 1000;
    }

}
