<?php

namespace App\Http\Middleware;

use App\Entrant;
use App\Event;
use Closure;

class CheckQuota
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $eventId = $request['event_id'];

        $count = Entrant::where('event_id', $eventId)->count();

        $event = Event::where('id',$eventId)->get()->toArray();

        if(!$event){
            abort(500, 'Nie ma takiego eventu');
        }

        $quota = $event[0]['quota'];

        if($count > $quota){
            abort(500, 'Nie ma miejsca');
        }

        return $next($request);
    }
}
