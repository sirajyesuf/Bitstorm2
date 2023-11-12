<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailOrPhone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }


    public function passes($attribute, $value)
    {
        // Check if the value is a valid email address
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        // Check if the value is a valid phone number
        // This is a basic example and may not cover all possible phone number formats
        $phonePattern = '/^\+?\d{1,4}?[-.\s]?\(?\d{1,4}\)?[-.\s]?\d{1,9}[-.\s]?\d{1,9}$/';
        return (bool) preg_match($phonePattern, $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid email address or phone number.';
    }
}
