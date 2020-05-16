<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class CheckUsersIds implements Rule
{
    /**
     * user
     *
     * @var [type]
     */
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $newValue = array_filter($value, function ($item) {
            return (int) $item !== $this->user->id;
        });

        return count($newValue) && count($newValue) <= 3;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Player must be between 1 - 3 and It cannot be your id';
    }
}
