<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class ListingCategory extends Model implements SluggableInterface
{
    use SluggableTrait;
    
    protected $table = 'listings_categories';

	protected $sluggable = [
        'build_from' => 'title',
        'save_to'    => 'slug',
    ];

    public function listings()
    {
    	$this->belongsTo('App\Models\Listing', 'id', 'category');
    }

    public function listingsCount()
    {
        return $this->hasMany('App\Models\Listing', 'category', 'id');
    }

    public function parentCategory()
    {
        return $this->belongsTo('App\Models\ListingCategory', 'id', 'parent');
    }

    public function parentCat()
    {
        return $this->hasOne('App\Models\ListingCategory', 'id', 'parent');
    }

    public function children()
    {
        return $this->hasMany('App\Models\ListingCategory', 'parent', 'id');
    }

    public function getActiveListings($id)
    {
        $listings = Listing::where('category', $id)
                    ->where('status', 3)->get();

        return $listings;
    }
}
