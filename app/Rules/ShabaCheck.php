<?php

namespace App\Rules;

use Closure;
use App\Models\Bank;
use Illuminate\Contracts\Validation\ValidationRule;

class ShabaCheck implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // dd(substr($value,0,2));
        if (empty(Bank::firstWhere(['pattern' => substr($value,0,2)]))) {
            $fail('The :attribute is not valid.');
        }
    }
}
