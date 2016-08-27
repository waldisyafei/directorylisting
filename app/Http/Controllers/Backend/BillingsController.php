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
                } else {
                    $item_id = $listing->listing_id;
                    $listing->status = 6;
                    $listing->save();
                    $billing->save();
                }
            }
            elseif ($billing->item_type == 'ads') {
                $ad = Ad::find($billing->item_id);
                $item_id = $ad->ad_id;

                $ad->status = 6;
                $ad->save();
                $billing->save();
            }
            //var_dump($billing->item_type);die();
            Mail::send('emails.send', ['user' => $billing->customer->customer_name, 'item_type' => $billing->item_type, 'item_id'=> $item_id], function ($m/*) use ($user*/) {
            $m->from('digirook@app.com', 'Your Application');

            $m->to('aldisma2pyk@gmail.com', 'Aldi Fajrin')->subject('Payment Confirmed!');
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
