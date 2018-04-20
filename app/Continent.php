<?php

namespace App;
use App\Country;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
	protected $table = 'continents';
	
   	public function countries()
    {
        return $this->hasMany(Country::class);
    }
}