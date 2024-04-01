<?php

namespace App\Import;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportValidationChecker implements ToModel, WithValidation, WithHeadingRow, SkipsEmptyRows
{
    use Importable, SkipsErrors, RegistersEventListeners;

    protected Import $importInstance;

    public function __construct(Import $importInstance)
    {
        $this->importInstance = $importInstance;
    }

    public function prepareForValidation($data, $index): array
    {
        if (method_exists($this->importInstance, 'prepareDataForValidation')) {
            return $this->importInstance->prepareDataForValidation($data);
        }
        return $data;
    }

    public function rules(): array
    {
        return $this->importInstance->rules();
    }

    public function customValidationMessages(): array
    {
        if (method_exists($this->importInstance, 'customValidationMessages')) {
            return $this->importInstance->customValidationMessages();

        }
        return [];
    }


    public function model(array $row)
    {
        // TODO: Implement model() method.
    }
}
