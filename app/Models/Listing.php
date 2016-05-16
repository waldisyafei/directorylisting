<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Listing extends Model implements SluggableInterface
{
    use SluggableTrait;

	protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    public function listingCategory()
    {
    	return $this->hasOne('\App\Models\ListingCategory', 'id', 'category');
    }

    public function package()
    {
    	return $this->hasOne('\App\Models\Package', 'id', 'package_id');
    }

    public function listingStatus()
    {
        return $this->hasOne('App\Models\ListingStatus', 'id', 'status');
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer', 'customer_id', 'customer_id');
    }
}
