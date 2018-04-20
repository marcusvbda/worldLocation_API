<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\State;
use App\Continent;


class Country extends Model
{
	protected $table = 'countries';

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }
}