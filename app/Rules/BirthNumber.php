<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BirthNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\d{6}\/?\d{3,4}$/', $value)) {
            $fail('Rodné číslo nemá správný formát (např. 000101/1234).');
            return;
        }

        $bn = str_replace('/', '', $value);

        if (strlen($bn) === 10) {
            if (intval($bn) % 11 !== 0) {
                $fail('Rodné číslo není platné (kontrolní součet nesedí).');
            }
        }
    }
}
