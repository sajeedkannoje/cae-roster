<?php

namespace App\Rules;

use Closure;
use App\Enum\ActivityEnum;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CustomActivityRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!Rule::enum(ActivityEnum::class)->passes($attribute, $value) && !preg_match('/^[A-Z]{2}\d+$/', $value)) {
            $fail('The :attribute must be a valid activity code');
        }
    }
}
