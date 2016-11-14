<?php

use App\Models\Listing;
use App\Models\ListingStatus;
use App\Models\ListingCategory;


function getActiveListings($category_id, $reqStatus)
{
	$status = ListingStatus::where('name', $reqStatus)->first();

	if (!$status) {
		return abort(404, 'getActiveListings where status "' . $reqStatus . '" not found.');
	}

	$listings = Listing::where(function($q) use($status, $category_id){
		$q->where('status', $status->id);
		$q->where('category', $category_id);
		$q->where('expired_date', '>=', date('Y-m-d H:i:s'));
	})->get();

	//$listings = Listing::where('status', $status->id)->where('category', $category_id)->get();

	return $listings;
}

function getCategories()
{
	# code...
}

function getCustomerListings($queries, $order, $paginate = null)
{

	$listings = Listing::where(function($query) use($queries){
		if (!empty($queries)) {
			foreach ($queries as $listingQuery) {
				if ($listingQuery['key'] == 'status') {
					$listing_status = ListingStatus::where('name', $listingQuery['value'])->first();

					if ($listing_status) {
						$query->where('status', $listing_status->id);
					}
				} else {
					$query->where($listingQuery['key'], $listingQuery['comparasion'] , $listingQuery['value']);
				}
			}
		}
	})->orderBy('created_at', $order)->paginate($paginate);

	return $listings;
}