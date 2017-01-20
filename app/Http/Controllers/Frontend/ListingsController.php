<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingCategory;

class ListingsController extends Controller
{
    public function category($slug)
    {
        $category = ListingCategory::where('slug', $slug)->first();

        if (!$category) {
            return abort(404, 'Category not found');
        }
        

        $listings = Listing::where('category', $category->id)->orderBy(\DB::raw('RAND()'))->get();
//dd($category->id);
        return view('frontend.pages.category', ['listings' => $listings, 'slug' => $slug]);
    }

    public function listings_details($category_slug, $listing_slug)
    {
        $category = ListingCategory::where('slug', $category_slug)->first();

        if (!$category) {
            return abort(404);
        }

        $listing = Listing::where('category', $category->slug)->orWhere('slug', $listing_slug)->first();

        if (!$listing) {
            return abort(404);
        }

        return view('frontend.pages.details', ['item' => $listing, 'slug' => $category_slug]);
    }
}
