<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;
use App\Country;


class State extends Model
{
	protected $table = 'states';

    public function cities()
    {
        return $this->hasMany(City::class);
    }
    public function country()
    {
        return $this->belongsTo(State::class);
    }
}