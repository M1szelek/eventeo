<?php

namespace App\Rules;

use App\Event;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class EventUpToDate implements Rule
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
        $event = Event::whereId($value)->first();
        $startTime = new Carbon($event['start_time']);
        $endTime = new Carbon($event['end_time']);
        $currentTime = Carbon::now();

        return $currentTime->between($startTime,$endTime);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Event out of date.';
    }
}
