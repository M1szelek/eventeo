<?php

namespace App\Rules;

use App\Entrant;
use App\Event;
use Illuminate\Contracts\Validation\Rule;

class EventOverQuota implements Rule
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
        $quota = Event::whereId($value)->first()['quota'];

        $count = Entrant::where('event_id', $value)->count();

        return $count < $quota ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Event over quota.';
    }
}
