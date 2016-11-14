<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
	protected $table = 'packages';
	
    public function listings()
    {
    	return $this->belongsTo('App\Models\Listing', 'package_id', 'id');
    }
	
    public function ad()
    {
    	return $this->belongsTo('App\Models\Ad', 'package_id', 'id');
    }
}
