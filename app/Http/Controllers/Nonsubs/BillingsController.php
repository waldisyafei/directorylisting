<?php

namespace App\Http\Controllers\Nonsubs;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Billing;
use Auth;
use Storage;
use File;
use Image;

class BillingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billings = Billing::where('customer_id', Auth::nonsubs()->get()->nonsub_id)
                    ->orderBy('created_at', 'ASC')->get();

        return view('nonSubscriber.pages.billings.list', ['billings' => $billings]);
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
            return view('nonSubscriber.pages.billings.view', ['billing' => $billing]);
        }
    }

    public function confirm_get($id)
    {
        $billing = Billing::find($id);

        if ($billing) {
            return view('nonSubscriber.pages.billings.confirm', ['billing' => $billing]);
        }
    }
    public function confirm_post(Request $request)
    {
        $billing = Billing::find($request->input('billing_id'));//dd($request->all());

        $billing->confirm_message = $request->input('message');

        if ($request->hasFile('image')) {
            $dir = public_path().'/storage/app/listings/billings/'.$billing->id . '/';
            $file = $request->file('image');
            $file_name = preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
            $relative_path = 'storage/app/listings/billings/' . $billing->id . '/' .$file_name;

            if(!File::exists(public_path().'/storage/app/listings/billings/'.$billing->id)) {
                $createDir = File::makeDirectory( public_path().'/storage/app/listings/billings/'.$billing->id,  0755, true);
            }

            Image::make($request->file('image'))->save($dir . $file_name);

            $billing->bukti_pembayaran = $relative_path;
        }

        /*if ($request->hasFile('image')) {
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

            $billing->bukti_pembayaran = json_encode([$relative_path]);
        }*/

        $billing->save();

        return redirect()->back()->with('success', 'Payment confirmed success!');
    }
}
