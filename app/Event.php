<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'description_in_form',
        'quota',
        'start_time',
        'end_time'
    ];

    public function entrants(){
        return $this->hasMany(Entrant::class);
    }
}
