<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Listing;
use App\Models\Customer;
use App\Models\Ad;
use Auth;
use Mail;
use PDF;
use App\Models\Zone;
use App\Models\Country;
use Setting;

class BillingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billings = Billing::orderBy('created_at', 'DESC')->get();

        return view('backend.pages.billings.list', ['billings' => $billings]);
    }

    public function index_listing()
    {
        $billings = Billing::where('item_type', 'listing')->orderBy('created_at', 'DESC')->get();

        return view('backend.pages.billings.list', ['billings' => $billings]);
    }

    public function index_ads()
    {
        $billings = Billing::where('item_type', 'ads')->orderBy('created_at', 'DESC')->get();

        return view('backend.pages.billings.list', ['billings' => $billings]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $billing = Billing::find($id);

        if ($billing) {
            return view('backend.pages.billings.view', ['billing' => $billing]);
        }
    }

    public function confirm_payment($id)
    {
        $billing = Billing::find($id);

        if ($billing) {
            $billing->status = 2;

            if ($billing->item_type == 'listing') {
                $listing = Listing::find($billing->item_id);
                if ($listing->been_active != '0') {
                    $expired = strtotime($listing->expired_date);
                    $listing_expired = $listing->expired_date;
                    $days = $listing->package->days;

                    if ($expired <= time()) {
                        $listing->expired_date = date('Y-m-d H:i:s', strtotime("+$days days"));
                        $listing->status = 3;
                    } else {
                        $listing->expired_date = date('Y-m-d H:i:s', strtotime("$listing_expired +$days days"));
                    }
                    $item_id = $listing->listing_id;
                    $listing->save();
                    $billing->save();
                    $billing_item_package_price = $billing->item->package->price;
                    $billing_item_package_discount = $billing->item->package->discount;
                    $billing_item_package_name = $billing->item->package->name;
                } else {
                    $item_id = $listing->listing_id;
                    $listing->status = 6;
                    $listing->save();
                    $billing->save();
                    $billing_item_package_price = $billing->item->package->price;
                    $billing_item_package_discount = $billing->item->package->discount;
                    $billing_item_package_name = $billing->item->package->name;
                }
            }
            elseif ($billing->item_type == 'ads') {
                $ad = Ad::find($billing->item_id);
                $item_id = $ad->ad_id;
                $billing_item_package_price= "";
                $billing_item_package_discount= "";
                $billing_item_package_name = "";

                $ad->status = 6;
                $ad->save();
                $billing->save();
            }

            $billing->customer ? $billing->customer->customer_name : $billing->item->address->company;
            $address = $billing->customer ? $billing->customer->address : $billing->item->address;
            $zone_name = Zone::find($address->zone_id)->name;
            $country_name = Country::find($address->country_id)->name;
            $note = $billing->customer ? Setting::get('ads.price_notes') : Setting::get('ads.noncust.price_notes');
            $price = $billing->customer ? floatval(Setting::get('ads.price_per_day')) : floatval(Setting::get('ads.noncust.price_per_day'));
            $billing_customer = null;
            $billing_customer ? Setting::get('ads.price_discount') : Setting::get('ads.noncust.price_discount');

            $data = array('billing_customer_customer_name' => $billing->customer->customer_name,
                    //'billing_item_address_company' => $billing->item->address->company,
                    'billing_item_address' => $billing->item->address,
                    'billing_customer_address' => $billing->customer->address,
                    'address_address_1' => $address->address_1,
                    'address_address_2' => $address->address_2,
                    'address_city' => $address->city,
                    'zone_name' => $zone_name,
                    'address_postcode' => $address->postcode,
                    'country_name' => $country_name,
                    'billing_created_at' => $billing->created_at,
                    'billing_item_type' => $billing->item_type,
                    'billing_item_ad_id' => $billing->item->ad_id,
                    'billing_item_listing_id' => $billing->item->listing_id,
                    'note' => $note,
                    'billing_item_package_name' => $billing_item_package_name,
                    'price' => $price,
                    'billing_item_days' => $billing->item->days,
                    'billing_customer' => $billing_customer,
                    'billing_item_package_price' => $billing_item_package_price,
                    'billing_item_package_discount' => $billing_item_package_discount,
                    'billing_amount' => $billing->amount
                );
            $pdf = PDF::loadView('backend.pages.billings.invoice',$data);

            //return $pdf->stream();

            Mail::send('emails.invoice', $data, function ($m) use($pdf) {
                
                $m->from('digirook@app.com', 'Your Application');

                $m->to('aldi.developer@gmail.com', 'Aldi Fajrin')->subject('Payment Confirmed!');

                $m->attachData($pdf->output(), "invoice.pdf");
            });

            return redirect()->back()->with('success', 'Pembayaran telah dikonfirmasi.');
        }
    }

    public function cancel_payment($id)
    {
        $billing = Billing::find($id);

        if ($billing) {
            $billing->status = 0;
            $billing->save();

            return redirect()->back()->with('success', 'Pembayaran Batal dikonfirmasi.');
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
        if (!Auth::user()->get()->can('can_delete_billing')) return abort(403);

        $billing = Billing::find($id);

        $billing->delete();

        return redirect('app-admin/billings/'. $billing->item_type)->with('success', 'Billing deleted successfully');
    }

    /**
     * Send an e-mail reminder to the user.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function sendEmailReminder(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });
    }
}
