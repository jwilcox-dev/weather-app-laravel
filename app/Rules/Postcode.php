<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Postcode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parts = explode(" ", $value);
    
        if (count($parts) < 2) {
            $fail('The :attribute is not in the correct format.');
            return;
        }

        $outwardCode = $parts[0];
        $inwardCode = $parts[1];

        if (strlen($outwardCode) < 2) {
            $fail('The :attribute outward code is too short.');
            return;
        }

        if (strlen($outwardCode) > 4) {
            $fail('The :attribute outward code is too long.');
            return;
        }

        if (!ctype_alpha($outwardCode[0])) {
            $fail('The :attribute should start with a letter.');
            return;
        }

        if (strlen($inwardCode) !== 3) {
            $fail('The :attribute inward code should be 3 characters exactly.');
            return;
        }

        if (!is_numeric($inwardCode[0])) {
            $fail('The :attribute inward code should start with a number.');
            return;
        }

    }
}
