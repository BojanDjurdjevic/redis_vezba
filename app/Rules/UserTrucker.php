<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserTrucker implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isTrucker = User::where('id', $value)->where('role', 'trucker')->exists();

        if(!$isTrucker) {
            $fail("This user is not a trucker!");
        }
    }
}
