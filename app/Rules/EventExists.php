<?php

namespace App\Rules;

use App\Event;
use Illuminate\Contracts\Validation\Rule;

class EventExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $event = Event::whereId($value)->first();

        return (bool)$event;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Event does not exist';
    }
}
