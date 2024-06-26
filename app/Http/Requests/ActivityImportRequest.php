<?php

namespace App\Http\Requests;

use App\Enum\Platform;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 *
 */
class ActivityImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attachment' => [ 'required', 'file', 'mimes:pdf,xls,xlsx,csv,txt,html,webcal' ],
            'crew_id'    => 'required|numeric',
            'platform'   => [ "nullable", Rule::enum(Platform::class) ],
        ];
    }
}
