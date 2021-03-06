<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    public function package()
    {
    	return $this->hasOne('\App\Models\Package', 'id', 'package_id');
    }

    public function billing()
    {
        return $this->hasOne('\App\Models\Billing', 'item_id', 'ad_id');
    }

    public function adStatus()
    {
        return $this->hasOne('App\Models\AdStatus', 'id', 'status');
    }

    public function customer()
    {
        if ($this->user_category == 1){
                return $this->hasOne('App\Models\User', 'user_id', 'customer_id');
            } elseif ($this->user_category == 2){
                return $this->hasOne('App\Models\Customer', 'customer_id', 'customer_id');
            }else {
                return $this->hasOne('App\Models\NonSubscriber', 'nonsub_id', 'customer_id');
            }
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address', 'address_id', 'address_id');
    }
}
