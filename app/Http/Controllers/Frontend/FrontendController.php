<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingCategory;
use App\Models\Ad;
use App\Http\Controllers\NotificationsController as Notification;
use Mail;

class FrontendController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $listings = Listing::where('status', '3')->orderBy(\DB::raw('RAND()'))->paginate(6);
        //dd($listings);
        return view('frontend.pages.home', ['listings' => $listings]);
    }

    
    public function category()
    {
        $listings = Listing::orderBy(\DB::raw('RAND()'))->get();

        return view('frontend.pages.category', ['listings' => $listings]);
    }

    // public function sub_category($slug)
    // { 
    //     $sub = ListingCategory::where('slug', $slug)->select('id')->first();

    //     $listings = Listing::where('category', $sub->id)->orderBy(\DB::raw('RAND()'))->get();

    //     return view('frontend.pages.category', ['listings' => $listings]);
    // }    

    public function ads_details( $link)
    {   
        $ad = Ad::where('ad_id', $link)->first();
    
        return view('frontend.pages.details', ['item' => $ad]);
    }

    public function updatePost(Request $request)
    {
        $sendNotif = Notification::send(2, $request->input('message'), 'customer');

        if ($sendNotif) {
            return "success";
        }

        return "failed";
    }
}
