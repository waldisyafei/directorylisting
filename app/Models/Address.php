<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'address_id';
    protected $table = 'address';


    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer', 'id', 'address_id');
    }
}
