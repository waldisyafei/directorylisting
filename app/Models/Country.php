<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $primaryKey = 'country_id';
    protected $table = 'country';

    public function zones()
    {
    	return $this->hasMany('App\Models\Zone');
    }
}
