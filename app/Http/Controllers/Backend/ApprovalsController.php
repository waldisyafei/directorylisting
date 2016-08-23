<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Ad;
use Auth;

class ApprovalsController extends Controller
{
    /**
     * get all un approved listings
     */
    public function listings()
    {
        if (Auth::user()->get()->can('can_approve_listing')) {
            $listings = Listing::where('status', 2)->orderBy('created_at', 'ASC')->paginate(15);

            return view('backend.pages.approvals.listings', ['listings' => $listings]);
        }

        return redirect()->back();
    }

    /**
     * Approve specified listing
     */
    public function approve_listing($id)
    {
        $listing = Listing::find($id);
        $listing_update = explode('-', $listing->listing_id);
        if (count($listing_update) != 1) {
            $listing_old_id = $listing_update[1];
            $listing_update = $listing_update[0];
            if ($listing_update == 'up') {
                $listing_old = Listing::find(intval($listing_old_id));

                if ($listing_old) {
                    if ($listing_old->been_active == '0') {
                        $listing_old->been_active = 1;

                        // setup expired date
                        $days = $listing_old->package->days;
                        $expired = date('Y-m-d H:i:s', strtotime("+$days days"));
                        $listing_old->expired_date = $expired;
                    }

                    $listing_old->status = 3;

                    $listing_old->customer_id = $listing->customer_id;
                    //$listing_old->listing_id =$listing->listing_id;
                    $listing_old->title = $listing->title;
                    $listing_old->content = $listing->content;
                    $listing_old->keywords = $listing->keywords;
                    $listing_old->tags = $listing->tags;
                    $listing_old->url = $listing->url;
                    $listing_old->price_from = $listing->price_from;
                    $listing_old->price_to = $listing->price_to;
                    $listing_old->review = $listing->review;
                    $listing_old->custom_tab_title = $listing->custom_tab_title;
                    $listing_old->custom_tab = $listing->custom_tab;
                    $listing_old->category = $listing->category;
                    $listing_old->package_id = $listing->package_id;
                    $listing_old->assets = $listing->assets;

                    $listing_old->save();
                }
            }
        }
        

        if ($listing) {
            if ($listing->been_active == '0') {
                $listing->been_active = 1;

                // setup expired date
                $days = $listing->package->days;
                $expired = date('Y-m-d H:i:s', strtotime("+$days days"));
                $listing->expired_date = $expired;
            }

            $listing->status = 3;

            $listing->save();
            
            add_system_log(Auth::user()->get()->id, '<a href="javascript:;">' . Auth::user()->get()->name . '</a> Approved Listing <a href="javascript:;" class="name">' . $listing->title . '</a>');

            return redirect()->back()->with('success', 'Listing Approved successfully.');
        }
    }

    /**
     * Reject specified listing
     */
    public function reject_listing($id)
    {
        $listing = Listing::find($id);

        if ($listing) {
            $listing->status = 4;

            $listing->save();
            
            add_system_log(Auth::user()->get()->id, '<a href="javascript:;" class="name">' . Auth::user()->get()->name . '</a> Rejected Listing <a href="javascript:;">' . $listing->title . '</a>');

            return redirect()->back()->with('success', 'Listing Rejected successfully.');
        }
    }

    /**
     * Show details specified listing
     */
    public function show_listing($id)
    {
        $listing = Listing::find($id);

        if ($listing) {
            return view('backend.pages.approvals.show_listing', ['listing'=> $listing]);
        }
    }

    /**
     * get all unapproved ads
     */
    public function ads()
    {
        $ads = Ad::where('status', 2)->orderBy('created_at', 'DSC')->paginate(15);

        return view('backend.pages.approvals.ads', ['ads' => $ads]);
    }

    /**
     * Show specified ad
     */
    public function show_ad($id)
    {
       $ad = Ad::find($id);

       if ($ad) {
           return view('backend.pages.approvals.show_ad', ['ad' => $ad]);
       }
    }

    public function approve_ad($id)
    {   
        $ad = Ad::find($id);
        $ad_update = explode('-', $ad->ad_id);
        if (count($ad_update) != 1) {
            $ad_old_id = $ad_update[1];
            $ad_update = $ad_update[0];
            if ($ad_update == 'up') {
                $ad_old = Ad::find(intval($ad_old_id));

                if ($ad_old) {
                    if ($ad_old->been_active == '0') {
                        $ad_old->been_active = 1;

                        // setup expired date
                        $days = $ad_old->days;
                        $expired = date('Y-m-d H:i:s', strtotime("+$days days"));
                        $ad_old->expired_date = $expired;
                    }

                    $ad_old->status = 3;

                    $ad_old->customer_id = $ad->customer_id;
                    //$ad_old->ad_id =$ad->ad_id;
                    $ad_old->title = $ad->title;
                    $ad_old->link = $ad->link;
                    $ad_old->show_date = $ad->show_date;
                    $ad_old->expired_date = $ad->expired_date;
                    /*$ad_old->tags = $ad->tags;
                    $ad_old->url = $ad->url;
                    $ad_old->price_from = $ad->price_from;
                    $ad_old->price_to = $ad->price_to;
                    $ad_old->review = $ad->review;
                    $ad_old->custom_tab_title = $ad->custom_tab_title;
                    $ad_old->custom_tab = $ad->custom_tab;
                    $ad_old->category = $ad->category;
                    $ad_old->package_id = $ad->package_id;*/
                    $ad_old->assets = $ad->assets;

                    $ad_old->save();
                }
            }
        }

       
        if ($ad) {
            $ad->status = 3;

            if ($ad->been_active == 0) {
                // First ads approvals
                $show_days = $ad->days;
                $show_date = $ad->show_date;

                $ad->expired_date = date('Y-m-d H:i:s', strtotime("$show_date +$show_days days"));
                $ad->been_active = 1;
            }
            if ($ad->save()) {
            
                add_system_log(Auth::user()->get()->id, '<a href="javascript:;">' . Auth::user()->get()->name . '</a> Approved Ad <a href="javascript:;" class="name">' . $ad->title . '</a>');
                return redirect()->back()->with('success', 'Ad approved successfully');
            }
        }
    }

    /**
     * Reject specified Ad
     */
    public function reject_ad($id)
    {
        $ad = Ad::find($id);

        if ($ad) {
            $ad->status = 4;

            $ad->save();
            
            add_system_log(Auth::user()->get()->id, '<a href="javascript:;" class="name">' . Auth::user()->get()->name . '</a> Rejected Ad <a href="javascript:;">' . $ad->title . '</a>');

            return redirect()->back()->with('success', 'Ad Rejected successfully.');
        }
    }
}
