<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ConsistNumbers implements Rule
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
        return boolval(preg_match('/[0-9]{1,}/', $value));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Password should contains at least one number!';
    }
}
