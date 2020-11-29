<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordStrength implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $score = 0;
        preg_match('/^(?=.*[a-z])/m', $value)? $score++ : false;
        preg_match('/^(?=.*[A-Z])/m', $value)? $score++ : false;
        preg_match('/^(?=.*[0-9])/m', $value)? $score++ : false;
        preg_match('/^(?=.*[!@#$%^&*])/m', $value)? $score++ : false;
        return $score>=2;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
