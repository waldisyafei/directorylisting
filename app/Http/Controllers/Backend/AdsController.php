<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Validator;
use App\Models\Ad;
use App\Models\Address;
use Setting;
use App\Models\Billing;

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
        if (!Auth::user()->get()->can('can_create_ads')) return abort(403);

        $validation = Validator::make($request->all(), [
            'days' => 'required|numeric',
            'customer_name' => 'required|max:100',
            'address_1' => 'required',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'password' => 'required'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $address = new Address;
        $address->company = $request->input('customer_name');
        $address->address_1 = $request->input('address_1');
        $address->address_2 = $request->input('address_2');
        $address->city = $request->input('city');
        $address->postcode = $request->input('postcode');
        $address->country_id = $request->input('country');
        $address->zone_id = $request->input('province');

        $address->save();

        $ads = new Ad;
        $ads->days = $request->input('days');
        $ads->address_id = $address->address_id;
        $ads->password = bcrypt($request->input('password'));
        $ads->save();
        $ads->ad_id = '28' . date('Y') . date('m') . str_pad((string)$ads->id, 5, 0, STR_PAD_LEFT);

        $ads->noncust_ad_link = url('noncust-ads/' . md5((string)$ads->ad_id, false));

        $price = Setting::get('ads.noncust.price_per_day') * $ads->days;
        $discount = Setting::get('ads.noncust.price_discount');
        $potongan = $discount / 100 * $price;
        $total = $price - $potongan;
        create_billing($ads->customer_id, $ads->id, 'ads', $total);

        $billing = Billing::where('item_id', $ads->id)->first();

        if ($billing) {
            $billing->status = 2;
            $billing->save();
            $ads->status = 6;
        }

        $ads->save();

        return redirect('app-admin/ads')->with('success', 'Non customer ads created!');

        /*if ($request->has('customer_id') && $request->input('customer_id') != 'choose-customer') {
            $ad = new Ad;
            $ad_count = (int)Ad::count() + 1;
            $ad->ad_id = '28' . date('Y') . date('m') . str_pad((string)$ad_count, 5, 0, STR_PAD_LEFT);
            $ad->customer_id = $request->customer_id != 'non-customer' ? $request->customer_id : null;

            if ($ad->save()) {
                return redirect('app-admin/ads/edit/'. $ad->id)->withSuccess('success', 'Ad create success.');
            }
        }*/
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
    public function update(Request $request, $id)
    {
        if (!Auth::user()->get()->can('can_edit_ads')) return abort(403);
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

        return redirect('app-admin/ads')->with('success', 'Ad deleted successfully');
    }
}
