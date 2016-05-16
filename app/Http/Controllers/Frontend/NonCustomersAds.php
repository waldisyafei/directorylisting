<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Ad;
use Session;
use App\Http\Controllers\NotificationsController as Notification;
use Mail;
use Hash;
use Validator;
use Storage;
use Image;

class NonCustomersAds extends Controller
{
    public function edit_ads($ads_hash)
    {
        if (!$ads_hash) {
            return abort(404);
        }

        $ads = Ad::where('noncust_ad_link', url('noncust-ads/'.$ads_hash))->first();

        if (!$ads) {
            return abort(404);
        }

        // Check Session
        if (!Session::has('noncustomer')) {
            return redirect('noncust-ads/login')->with('error', 'Please login with your ads id and ads password.');
        }


        return view('customer.pages.advertising.edit', ['ad' => $ads]);
    }

    public function login(Request $request)
    {
        if (Session::has('noncustomer')) {
            return 're';
            $ads = Ad::where('ad_id', Session::get('noncustomer'));

            if ($ads) {
                return redirect($ads->noncust_ad_link);
            }
        }
        return view('auth.login');
    }

    public function do_login(Request $request)
    {
        $rules = [
            'ads_id' => 'required',
            'password' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect()->back()->withErrors();
        }

        $ads_id = $request->input('ads_id');
        $ads = Ad::where('ad_id', $ads_id)->first();

        if (!$ads) {
            return redirect()->back()->with('error', 'Ads not found');
        }

        $pass = $request->input('password');

        if (Hash::check($pass, $ads->password)) {
            Session::put('noncustomer', $ads->ad_id);

            return redirect($ads->noncust_ad_link);
        }

        return redirect()->back()->withInput($request->only('ads_id'))->with('error', 'Ads ID and password does not match our records!');
    }

    public function logout()
    {
        if (Session::has('noncustomer')) {
            Session::forget('noncustomer');
        }

        return redirect('noncust-ads/login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'link' => 'required|max:255'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $ad = Ad::where('ad_id', Session::get('noncustomer'))->first();
        $ad->title = $request->input('title');
        $ad->link = $request->input('link');
        $ad->show_date = $request->input('show_date');
        $ad->status = 2;
        
        if ($request->hasFile('image')) {
            $dir = storage_path().'/app/cs/assets/';
            $file = $request->file('image');
            $file_name = preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
            $thumb_admin = 'thumb-admin-'.$file_name;
            $thumb = 'thumb-'.$file_name;
            $relative_path = 'storage/app/cs/assets/' . $ad->ad_id . '/' . $file_name;
            $relative_thumb_admin_path = 'storage/app/cs/assets/'.$thumb_admin;
            $relative_path = 'storage/app/cs/assets/'.$file_name;

            if (!Storage::disk('local')->exists('cs/assets/' . $ad->ad_id)) {
                Storage::makeDirectory('cs/assets/' . $ad->ad_id);
            }

            Image::make($request->file('image'))->save($dir . $file_name);
            Image::make($request->file('image'))->resize(150, 120)->save($dir . $thumb_admin);
            Image::make($request->file('image'))->resize(200, 200)->save($dir . $thumb);

            $ad->assets = json_encode([$relative_path]);
        }

        if ($ad->save()) {
            return redirect($ad->noncust_ad_link)->withSuccess('success', 'Ads Updated success.');
        }
    }
}
