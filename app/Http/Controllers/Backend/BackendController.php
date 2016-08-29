<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Country;
//use Tracker;

class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $users = Tracker::users(60 * 24);var_dump($users);die();
        return view('backend.pages.dashboard'/*, ['visitor' => $visitor]*/);
    }

    public function getZone(Request $request)
    {
    	$country_id = $request->input('country_id');

    	$country = Country::find($country_id);

    	return response()->json([
    		'status' => 'success',
    		'results' => $country->zones->toArray()
		]);
    }
}
