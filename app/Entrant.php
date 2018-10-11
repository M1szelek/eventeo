<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrant extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'phone',
        'event_id'
    ];

    public function event(){
        return $this->hasOne(Event::class);
    }
}
