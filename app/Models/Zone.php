<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $primaryKey = 'zone_id';
    protected $table = 'zone';

    public function country()
    {
    	$this->belongsTo('App\Models\Country');
    }
}
