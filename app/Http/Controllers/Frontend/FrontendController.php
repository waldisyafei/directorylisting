<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Listing;
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
        $ads = Ad::where('status', '3')->orderBy(\DB::raw('RAND()'))->paginate(20);

        return view('frontend.pages.home', ['listings' => $listings, 'ads' => $ads]);
    }

    
    public function category()
    {
        $listings = Listing::orderBy(\DB::raw('RAND()'))->get();

        return view('frontend.pages.category', ['listings' => $listings]);
    }

    public function details()
    {
        return view('frontend.pages.details');
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
