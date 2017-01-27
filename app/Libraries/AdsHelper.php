<?php

use App\Models\Ad;
use App\Models\AdEdit;
use App\Models\AdStatus;
use App\Models\AdMeta;
use App\Models\SystemLog;

function getAds($status)
{
	$listingStatus = AdStatus::where('name', $status)->first();

	$listings = Ad::where('status', $listingStatus->id)->get();

	return $listings;
}

function getAdsApprove($status)
{
	$listingStatus = AdStatus::where('name', $status)->first();

	$listings = AdEdit::where('status', $listingStatus->id)->get();

	return $listings;
}

function getActiveAds($order = false)
{
	$rowOrder = $order;
	$ads = Ad::where(function($q) use($rowOrder){
		$now_date = date('Y-m-d H:i:s');
		$q->where('status', 3);
		$q->where('show_date', '<=', $now_date);
		$q->where('expired_date', '>=', $now_date);

		if ($rowOrder === true) {
			$q->orderByRaw('RAND()');
		}
	})->paginate(10);

	return $ads;
}

function getActiveAdsDsc($order = false)
{
	$rowOrder = $order;
	$now_date = date('Y-m-d H:i:s');
	$ads = Ad::where('status', 3)->where('show_date', '<=', $now_date)->where('expired_date', '>=', $now_date)->orderBy('id', 'DSC')->paginate(10);

	return $ads;
}


function getActiveAdsAsc($order = false)
{
	$rowOrder = $order;
	$now_date = date('Y-m-d H:i:s');
	$ads = Ad::where('status', 3)->where('show_date', '<=', $now_date)->where('expired_date', '>=', $now_date)->orderBy('id', 'ASC')->paginate(10);

	return $ads;
}

function add_iklan_meta($key, $value, $listingId)
{
	$meta = new AdMeta;

	$meta->listing_id = $listingId;
	$meta->meta_key = $key;
	$meta->meta_value = $value;

	if ($meta->save()) {
		return true;
	}
}

function get_iklan_meta($key, $listingId)
{
	$meta = AdMeta::where('listing_id', $listingId)->where('meta_key', $key)->first();

	if (!$meta) {
		return false;
	}

	return $meta->meta_value;
}

function update_iklan_meta($key, $value, $listingId)
{
	$meta = AdMeta::where('listing_id', $listingId)->where('meta_key', $key)->first();

	if (!$meta) {
		return false;
	}

	$meta->meta_value = $value;

	if ($meta->save()) {
		return true;
	}
}

function delete_iklan_meta($key, $listingId)
{
	$meta = AdMeta::where('listing_id', $listingId)->orWhere('meta_key', $key)->first();

	if (!$meta) {
		return false;
	}

	$meta->delete();

	return true;
}

function query_ads($query)
{
	$limit = $query['limit'];
	$orderBy = $query['orderby'];
	$order = $query['order'];

	/*if (isset($query['meta_key'])) {
		$listings = Ad::where('listing_meta ' . $query['meta_key'])
	}*/
}