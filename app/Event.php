<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
      'name',
      'description',
      'description_in_form',
      'quota'
    ];

    public function entrants(){
        return $this->hasMany(Entrant::class);
    }
}
