<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Validator;
use App\Models\Ad;
use App\Models\AdEdit;
use App\Models\Address;
use Setting;
use App\Models\Billing;
use App\Models\History;
use Session;
use Storage;
use Image;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->get()->can('can_view_ads')) return abort(403);

        $ads = Ad::orderBy('created_at', 'DESC')->paginate(15);

        return view('backend.pages.ads.list', ['ads' => $ads]);
    }

    public function index_noncust()
    {
        $ads = Ad::where('customer_id', Auth::user()->get()->user_id)->get();

        return view('backend.pages.ads.list-noncust', ['ads' => $ads]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->get()->can('can_create_ads')) return abort(403);

        return view('backend.pages.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ad_id = array();

        foreach ($request->input('ads') as $adsRequest) {
            $ad = new Ad;
            $ad->customer_id = Auth::user()->get()->user_id;
            $ad->user_category = 1;
            $ad->address_id = Auth::user()->get()->address_id;
            $ad->days = $adsRequest['days'];

            if ($ad->save()) {
                $ad->ad_id = '28' . date('Y') . date('m') . str_pad((string)$ad->id, 5, 0, STR_PAD_LEFT);
                $ad->save();
                $price = Setting::get('ads.price_per_day') * $adsRequest['days'];
                $discount = Setting::get('ads.price_discount');
                $potongan = $discount / 100 * $price;
                $total = $price - $potongan;
                create_billing($ad->customer_id, $ad->id, 'ads', $total, 1);
            }
            $ad_id[] = $ad->id;
        }

        $ads = array();
        foreach ($ad_id as $id) {
            $ads[] = Ad::find($id);
        }

        Session::put('ads', $ads);

        //return redirect('app-admin/ads/buy/complete');
        return redirect('app-admin/ads')->with('success', 'Ad inserted successfully');
       
    }

    public function buyComplete()
    {
        if (Session::has('ads')) {
            $ads = Session::get('ads');
            //Session::forget('listings');
        } else {
            return redirect('app-admin/ads');
        }

        return view('backend.pages.ads.buy-complete', array('ads' => $ads));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::user()->get()->can('can_view_ads')) return abort(403);

        $ad = Ad::find($id);

        if ($ad) {
            return view('backend.pages.ads.show');
        }
        
        return abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->get()->can('can_edit_ads')) return abort(403);

        $ad = Ad::find($id);

        if ($ad) {
            return view('backend.pages.ads.edit', ['ad' => $ad]);
        }

        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, $id)
    //{
    //    if (!Auth::user()->get()->can('can_edit_ads')) return abort(403);
    //}

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
        $ad->customer_id = Auth::user()->get()->user_id;
        $ad->user_category = 1;
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
        $history->customer_id = 'Non Customer';
        $history->item_id = $ad->ad_edit_id;
        $history->item_type = 'ads';

        $history_old = new History;
        $history_old->customer_id = 'Non Customer';
        $history_old->item_id = $ad_old->ad_id;
        $history_old->item_type = 'ads';

        if ($ad->save()) {
            $ad_old->save();
            $history->save();
            $history_old->save();
            return redirect('app-admin/ads')->withSuccess('success', 'Ads create success.');
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
        if (!Auth::user()->get()->can('can_delete_ads')) return abort(403);

        $ad = Ad::find($id);

        $ad->delete();
        return redirect()->back()->with('success', 'Ad deleted successfully.');
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

        return view('backend.pages.ads.renew', ['ad' => $ad]);
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
                create_billing($ad->customer_id, $ad->id, 'ads', $total, 1);

                $ads_id[] = $ad->id;
            }
        }

        $ads = array();
        foreach ($ads_id as $id) {
            $ads[] = Ad::find($id);
        }

        Session::put('ads', $ads);

        return redirect('app-admin/ads/buy/complete');
    }

    public function suspend($id)
    {
        $ad_update = AdEdit::find($id);
        $ad = Ad::find($ad_update->edit);

        if ($ad_update) {
            $ad_update->status = 2;
            $ad->status = 2;
            $ad_update->save();
            $ad->save();

            return redirect('app-admin/ads')->with('success', 'Ad suspended successfully');
        }
    }
}
