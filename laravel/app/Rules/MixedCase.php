<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MixedCase implements Rule
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
        $has_uppercase = false;
        $has_lowercase = false;

        $value = str_split($value);
        for ($i = 0; $i < sizeof($value); $i++) {
            if ($has_uppercase && $has_lowercase) {
                break;
            }

            if (ctype_lower($value[$i])) {
                $has_lowercase = true;
            } else if (ctype_upper($value[$i])) {
                $has_uppercase = true;
            }
        }

        return $has_lowercase && $has_uppercase;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There should be both uppercase and lowercase letters in your password!';
    }
}
