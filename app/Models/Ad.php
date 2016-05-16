<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    public function package()
    {
    	return $this->hasOne('\App\Models\Package', 'id', 'package_id');
    }

    public function adStatus()
    {
        return $this->hasOne('App\Models\AdStatus', 'id', 'status');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'customer_id', 'customer_id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address', 'address_id', 'address_id');
    }
}
