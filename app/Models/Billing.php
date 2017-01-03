<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
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

    public function nonsubs()
    {
        return $this->hasOne('App\Models\NonSubscriber', 'nonsub_id', 'customer_id');
    }

    public function item()
    {
    	if ($this->item_type == 'listing') {
    		return $this->hasOne('App\Models\Listing', 'id', 'item_id');
    	}

    	return $this->hasOne('App\Models\Ad', 'id', 'item_id');
    }
}
