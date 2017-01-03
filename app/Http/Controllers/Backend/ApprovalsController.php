<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingEdit;
use App\Models\Ad;
use App\Models\AdEdit;
use Auth;

class ApprovalsController extends Controller
{
    /**
     * get all un approved listings
     */
    public function listings()
    {
        if (Auth::user()->get()->can('can_approve_listing')) {
            $listings = ListingEdit::where('status', 2)->orderBy('created_at', 'ASC')->paginate(15);//dd($listings);

            return view('backend.pages.approvals.listings', ['listings' => $listings]);
        }

        return redirect()->back();
    }

    /**
     * Approve specified listing
     */
    public function approve_listing($id)
    {
        $listing_update = ListingEdit::find($id);
        $listing = Listing::find($listing_update->edit);

        //isi update ke ad yg lama
        $listing->title = $listing_update->title;
        $listing->content = $listing_update->content;
        $listing->review = $listing_update->review;
        $listing->custom_tab = $listing_update->custom_tab;
        $listing->custom_tab_title = $listing_update->custom_tab_title;
        $listing->keywords = $listing_update->keywords;
        $listing->tags = $listing_update->tags;
        $listing->url = $listing_update->url;
        $listing->price_from = $listing_update->price_from;
        $listing->price_to = $listing_update->price_to;
        $listing->category = $listing_update->category;
      
        $listing->assets = $listing_update->assets;
        $listing->status = 3;//active
        $listing->been_active = 1;

        //ganti keterangan edit dan status
        $listing_update->status = 7;//tidak lagi diperhitungkan di dalam database karena sudah direkam di history
        $listing->edit = $listing_update->id;
            
        if ($listing->save()) {
            $listing_update->save();
            add_system_log(Auth::user()->get()->id, '<a href="javascript:;">' . Auth::user()->get()->name . '</a> Approved Ad <a href="javascript:;" class="name">' . $listing->title . '</a>');
            return redirect()->back()->with('success', 'Listing approved successfully');
        }
        }
    
    /**
     * Reject specified listing
     */
    public function reject_listing($id)
    {

        $listing_update = ListingEdit::find($id);
        $listing = Listing::find($listing_update->edit);

        if ($listing) {
            $listing->status = 4;
            $listing_update->status = 4;

            $listing->save();
            $listing_update->save();
            
            add_system_log(Auth::user()->get()->id, '<a href="javascript:;" class="name">' . Auth::user()->get()->name . '</a> Rejected Listing <a href="javascript:;">' . $listing->title . '</a>');

            return redirect()->back()->with('success', 'Listing Rejected successfully.');
        }
    }

    /**
     * Show details specified listing
     */
    public function show_listing($id)
    {
        $listing = ListingEdit::find($id);

        if ($listing) {
            return view('backend.pages.approvals.show_listing', ['listing'=> $listing]);
        }
    }

    /**
     * get all unapproved ads
     */
    public function ads()
    {
        $ads = AdEdit::where('status', 2)->orderBy('created_at', 'DSC')->paginate(15);

        return view('backend.pages.approvals.ads', ['ads' => $ads]);
    }

    /**
     * Show specified ad
     */
    public function show_ad($id)
    {
       $ad = AdEdit::find($id);

       if ($ad) {
           return view('backend.pages.approvals.show_ad', ['ad' => $ad]);
       }
    }

    public function approve_ad($id)
    {   
        $ad_update = AdEdit::find($id);
        $ad = Ad::find($ad_update->edit);

        //isi update ke ad yg lama
        $ad->title = $ad_update->title;
        $ad->link = $ad_update->link;
        $ad->show_date = $ad_update->show_date;
        $ad->expired_date = $ad_update->expired_date;
        $ad->assets = $ad_update->assets;
        $ad->status = 3;//active
        $ad->been_active = 1;

        //ganti keterangan edit dan status
        $ad_update->status = 7;//tidak lagi diperhitungkan di dalam database karena sudah direkam di history
        $ad->edit = $ad_update->id;

        /*$ad_update = explode('-', $ad->ad_id);
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
                    $ad_old->expired_date = $ad->expired_date;*/
                    /*$ad_old->tags = $ad->tags;
                    $ad_old->url = $ad->url;
                    $ad_old->price_from = $ad->price_from;
                    $ad_old->price_to = $ad->price_to;
                    $ad_old->review = $ad->review;
                    $ad_old->custom_tab_title = $ad->custom_tab_title;
                    $ad_old->custom_tab = $ad->custom_tab;
                    $ad_old->category = $ad->category;
                    $ad_old->package_id = $ad->package_id;*/
                    /*$ad_old->assets = $ad->assets;

                    $ad_old->save();
                }
            }
        }
        */
               
        /*if ($ad) {
            $ad->status = 3;

            if ($ad->been_active == 0) {
                // First ads approvals
                $show_days = $ad->days;
                $show_date = $ad->show_date;

                $ad->expired_date = date('Y-m-d H:i:s', strtotime("$show_date +$show_days days"));
                $ad->been_active = 1;
            }*/
            if ($ad->save()) {
                $ad_update->save();
                add_system_log(Auth::user()->get()->id, '<a href="javascript:;">' . Auth::user()->get()->name . '</a> Approved Ad <a href="javascript:;" class="name">' . $ad->title . '</a>');
                return redirect()->back()->with('success', 'Ad approved successfully');
            }
        //}
    }

    /**
     * Reject specified Ad
     */
    public function reject_ad($id)
    {
        $ad_update = AdEdit::find($id);
        $ad = Ad::find($ad_update->edit);

        if ($ad) {
            $ad->status = 4;
            $ad_update->status = 4;

            $ad->save();
            $ad_update->save();
            
            add_system_log(Auth::user()->get()->id, '<a href="javascript:;" class="name">' . Auth::user()->get()->name . '</a> Rejected Ad <a href="javascript:;">' . $ad->title . '</a>');

            return redirect()->back()->with('success', 'Ad Rejected successfully.');
        }
    }
}
