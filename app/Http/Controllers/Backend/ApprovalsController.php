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
        $ads = Ad::where('status', 2)->orderBy('created_at', 'ASC')->paginate(15);

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
        $ad = Listing::find($id);

        if ($ad) {
            $ad->status = 4;

            $ad->save();
            
            add_system_log(Auth::user()->get()->id, '<a href="javascript:;" class="name">' . Auth::user()->get()->name . '</a> Rejected Ad <a href="javascript:;">' . $ad->title . '</a>');

            return redirect()->back()->with('success', 'Ad Rejected successfully.');
        }
    }
}
