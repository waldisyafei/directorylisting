<?php

use Illuminate\Http\Request;

use App\Models\Listing;
use App\Models\ListingStatus;
use App\Models\ListingMeta;
use App\Models\SystemLog;


define( 'MINUTE_IN_SECONDS', 60 );
define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS   );
define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS    );
define( 'MONTH_IN_SECONDS',  30 * DAY_IN_SECONDS    );
define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS    );

function getListings($status)
{
	$listingStatus = ListingStatus::where('name', $status)->first();

	$listings = Listing::where('status', $listingStatus->id)->get();

	return $listings;
}

function getSubscriberListings($status)
{
	$listingStatus = ListingStatus::where('name', $status)->first();

	$listings = Listing::where('status', $listingStatus->id)
		->where('customer_id', Auth::customer()->get()->customer_id)
		->get();
		
	return $listings;
}

function add_listing_meta($key, $value, $listingId)
{
	$meta = new ListingMeta;

	$meta->listing_id = $listingId;
	$meta->meta_key = $key;
	$meta->meta_value = $value;

	if ($meta->save()) {
		return true;
	}
}

function get_listing_meta($key, $listingId)
{
	$meta = ListingMeta::where('listing_id', $listingId)->where('meta_key', $key)->first();

	if (!$meta) {
		return false;
	}

	return $meta->meta_value;
}

function update_listing_meta($key, $value, $listingId)
{
	$meta = ListingMeta::where('listing_id', $listingId)->where('meta_key', $key)->first();

	if (!$meta) {
		return false;
	}

	$meta->meta_value = $value;

	if ($meta->save()) {
		return true;
	}
}

function delete_listing_meta($key, $listingId)
{
	$meta = ListingMeta::where('listing_id', $listingId)->orWhere('meta_key', $key)->first();

	if (!$meta) {
		return false;
	}

	$meta->delete();

	return true;
}

function query_listings($query)
{
	$limit = $query['limit'];
	$orderBy = $query['orderby'];
	$order = $query['order'];

	/*if (isset($query['meta_key'])) {
		$listings = Listing::where('listing_meta ' . $query['meta_key'])
	}*/
}

/*=====================================
=            Log Functions            =
=====================================*/

function add_system_log($user_id, $log_text)
{
	$log = new SystemLog;

	$log->user = $user_id;
	$log->log_text = $log_text;

	if ($log->save()) {
		return true;
	}
}

function get_system_logs($limit)
{
	$logs = SystemLog::orderBy('created_at', 'DESC')->paginate($limit);

	return $logs;
}

/*=====  End of Log Functions  ======*/


/*-----------------------------------------------------------------------------------*/
/*  human_time_diff Custom
/*-----------------------------------------------------------------------------------*/
function human_time_diff( $from, $to = '' ) {
    if ( empty( $to ) )
            $to = time();
    $diff = (int) abs( $to - $from );
    if ( $diff <= HOUR_IN_SECONDS ) {
            $mins = round( $diff / MINUTE_IN_SECONDS );
            if ( $mins <= 1 ) {
                    $mins = 1;
            }

            if ($mins > 1) {
                $since = sprintf( '%s mins ago', $mins);
            } else {
                $since = sprintf( '%s min ago', $mins);
            }
            /* translators: min=minute */
            $since = sprintf( '%s mins', $mins );
    } elseif ( ( $diff <= DAY_IN_SECONDS ) && ( $diff > HOUR_IN_SECONDS ) ) {
            $hours = round( $diff / HOUR_IN_SECONDS );
            if ( $hours <= 1 ) {
                    $hours = 1;
            }

            if ($hours > 1) {
                $since = sprintf( '%s hours ago', $hours);
            } else {
                $since = sprintf(  '%s hour ago', $hours);
            }
    } elseif ( $diff >= DAY_IN_SECONDS ) {
            $days = round( $diff / DAY_IN_SECONDS );
            if ( $days <= 1 ) {
                    $days = 1;
            }

            if ($days > 1) {
                $since = sprintf(  '%s days ago', $days);
            } else {
                $since = sprintf( '%s day ago', $days);
            }
    }
    return $since;
}