<?php

namespace App\Http\Controllers\Nonsubs;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdEdit;
use App\Models\History;
use Validator;
use Auth;
use Storage;
use Image;
use App\Models\Package;
use Setting;
use Session;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::where('customer_id', Auth::nonsubs()->get()->nonsub_id)->get();//->count();dd($ads);

        return view('nonSubscriber.pages.advertising.list', ['ads' => $ads]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nonsubs.pages.advertising.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'link' => 'required|max:255',
            'image' => 'required'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $ad = new Ad;
        $ad->save();
        $ad->title = $request->input('title');
        $ad->link = $request->input('link');
        $ad->nonsubs_id = Auth::nonsubs()->get()->nonsubs_id;
        $ad->show_date = $request->input('show_date');
        $ad->expired_date = $request->input('expired_date');
        $stop_date = Package::find($request->input('package_id'))->days;
        $ad->expire_date = date('Y-m-d H:i:s', strtotime($request->input('show_date') . ' +'. $stop_date .' day'));

        
        if ($request->hasFile('image')) {
            $dir = public_path().'/storage/app/cs/assets/';
            $file = $request->file('image');
            $file_name = preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
            $thumb_admin = 'thumb-admin-'.$file_name;
            $thumb = 'thumb-'.$file_name;
            $relative_path = 'storage/app/cs/assets/'.$file_name;
            $relative_thumb_admin_path = 'storage/app/cs/assets/'.$thumb_admin;
            $relative_path = 'storage/app/cs/assets/'.$file_name;

            if (!Storage::disk('local')->exists('cs/assets')) {
                Storage::makeDirectory('cs/assets');
            }

            Image::make($request->file('image'))->save($dir . $file_name);
            Image::make($request->file('image'))->resize(150, 120)->save($dir . $thumb_admin);
            Image::make($request->file('image'))->resize(200, 200)->save($dir . $thumb);

            $ad->assets = json_encode([$relative_path]);
        }

        if ($ad->save()) {
            $ad->ad_id = '28' . date('Y') . date('m') . str_pad((string)$ad->id, 5, 0, STR_PAD_LEFT);
            create_billing($ad->nonsubs_id, $ad->id, 'ad', $ad->package->price);
            return redirect('account/cs/edit/'. $ad->id)->withSuccess('success', 'Ad create success.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = Ad::find($id);

        if (!$ad) {
            return abort(404);
        }

        if ($ad->status == 1) {
            return redirect()->back()->with('error', 'Unable to process this request. [Payment Not Completed]');
        }

        return view('nonSubscriber.pages.advertising.edit', ['ad' => $ad]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'link' => 'required|max:255'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $ad_old = Ad::find($id);
        $ad_old->status = 2;

        $ad = new AdEdit;
        $ad->ad_edit_id =$ad_old->ad_id;
        $ad->title = $request->input('title');
        $ad->edit = $ad_old->id;
        $ad->link = $request->input('link');
        $ad->customer_id = Auth::nonsubs()->get()->nonsub_id;
        $ad->show_date = $request->input('show_date');
        $ad->expired_date = $request->input('expired_date');
        $ad->status = 2;
        $ad->ad_edit_id = $ad_old->ad_id;
        //$stop_date = $ad_old->days;
        //$ad->expired_date = date('Y-m-d H:i:s', strtotime($request->input('show_date') . ' +'. $stop_date .' day'));
        
        if ($request->hasFile('image')) {
            //$dir = storage_path().'/app/cs/assets/';
            $dir = public_path().'/storage/app/cs/assets/';
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
        }elseif ($ad_old->assets) {
            $ad->assets = $ad_old->assets;
        }

        $history = new History;
        $history->customer_id = $ad->customer_id;
        $history->item_id = $ad->ad_edit_id;
        $history->item_type = 'ads';

        $history_old = new History;
        $history_old->customer_id = $ad_old->customer_id;
        $history_old->item_id = $ad_old->ad_id;
        $history_old->item_type = 'ads';

        if ($ad->save()) {
            $ad_old->save();
            $history->save();
            $history_old->save();
            return redirect('nonsubs/ads')->withSuccess('success', 'Ads create success.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function wizard()
    {
        return view('nonSubscriber.pages.advertising.buy');
    }

    public function buy()
    {
        return view('nonSubscriber.pages.advertising.buy');
    }

    public function buy_ads_slot(Request $request)
    {
        $ad_id = array();

        foreach ($request->input('ads') as $adsRequest) {
            $ad = new Ad;
            $ad->customer_id = Auth::nonsubs()->get()->nonsub_id;
            $ad->address_id = Auth::nonsubs()->get()->address_id;
            $ad->days = $adsRequest['days'];

            if ($ad->save()) {
                $ad->ad_id = '28' . date('Y') . date('m') . str_pad((string)$ad->id, 5, 0, STR_PAD_LEFT);
                $ad->save();
                $price = Setting::get('ads.price_per_day') * $adsRequest['days'];
                $discount = Setting::get('ads.price_discount');
                $potongan = $discount / 100 * $price;
                $total = $price - $potongan;
                create_billing($ad->customer_id, $ad->id, 'ads', $total);
            }
            $ad_id[] = $ad->id;
        }

        $ads = array();
        foreach ($ad_id as $id) {
            $ads[] = Ad::find($id);
        }

        Session::put('ads', $ads);

        return redirect('nonsubs/ads/buy/complete');
    }

    public function buyComplete()
    {
        if (Session::has('ads')) {
            $ads = Session::get('ads');
            //Session::forget('listings');
        } else {
            return redirect('nonsubs/ads');
        }

        return view('nonSubscriber.pages.advertising.buy-complete', array('ads' => $ads));
    }

    public function renew($id)
    {
        $ad = Ad::find($id);

        if (!$ad) {
            return abort(404);
        }

        /*if ($ad->status == 1) {
            return redirect()->back()->with('error', 'Unable to process this request. [Payment Not Completed]');
        }*/

        return view('nonSubscriber.pages.advertising.renew', ['ad' => $ad]);

        /*$ads = Ad::where('customer_id', Auth::nonsubs()->get()->nonsubs_id)->get();

        *///return view('nonSubscriber.pages.advertising.renew', array('ads' => $ads));
    }

    public function renew_ads_slot(Request $request)
    {
        $ads_id = array();

        foreach ($request->input('ads') as $key => $adsRequest) {
            if ($adsRequest['days'] != '0') {
                $ad = Ad::where('id', $key)->first();
                if ($ad->status == 3) {
                    $ad->days = $adsRequest['days'] + $ad->days;
                }else
                   $ad->days = $adsRequest['days'];

                if ($ad->status == 5) {
                    $ad->status = 1;
                }

                $ad->save();
                $price = Setting::get('ads.price_per_day') * $adsRequest['days'];
                $discount = Setting::get('ads.price_discount');
                $potongan = $discount / 100 * $price;
                $total = $price - $potongan;
                create_billing($ad->customer_id, $ad->id, 'ads', $total);

                $ads_id[] = $ad->id;
            }
        }

        $ads = array();
        foreach ($ads_id as $id) {
            $ads[] = Ad::find($id);
        }

        Session::put('ads', $ads);

        return redirect('nonsubs/ads/buy/complete');
    }
}
