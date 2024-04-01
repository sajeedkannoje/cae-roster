<?php

namespace App\Import;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Validators\ValidationException;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

abstract class Import implements ImportInterface
{
    use Importable, SkipsErrors, RegistersEventListeners;

    /**
     * @param $filePath
     *
     * @return array|null
     */
    public function validateImport($filePath): array|null
    {
        $validator = new ImportValidationChecker($this);
        try {
            $validator->import($filePath);
        } catch (ValidationException $error) {
            return $error->failures();
        }
        return null;
    }


    public function chunkSize(): int
    {
        return 1000;
    }

}
