<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\State;

class City extends Model
{
	protected $table = 'cities';
   	public function state()
    {
        return $this->belongsTo(State::class);
    }
}