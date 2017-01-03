<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Billing;
use Auth;
use Storage;
use File;
use Image;
use Validator;

class BillingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billings = Billing::where('customer_id', Auth::customer()->get()->customer_id)
                    ->orderBy('created_at', 'ASC')->get();

        return view('customer.pages.billings.list', ['billings' => $billings]);
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
            return view('customer.pages.billings.view', ['billing' => $billing]);
        }
    }

    public function confirm_post(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'message' => 'max:255'
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        if($request->input('message') == null && $request->file('image') == null)
            return redirect()->back()->withInput()->withErrors('You have to fill confirm message or attach an image to confirm payment');
        
        $billing = Billing::find($request->input('billing_id'));//dd($request->all());

        $billing->confirm_message = $request->input('message');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $_FILES['image']['name'];
            $ext = end((explode(".", $filename)));//dd($ext);
            $file_name = preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
            $relative_path = 'storage/app/listings/billings/' . $billing->id . '/' .$file_name;
            if($ext == "pdf"){
                if(!File::exists(public_path().'/storage/app/listings/billings/'.$billing->id)) {
                    $createDir = File::makeDirectory( public_path().'/storage/app/listings/billings/'.$billing->id,  0755, true);
                }
                $request->file('image')->move(
                    public_path().'/storage/app/listings/billings/'.$billing->id . '/', $file_name
                );

                $billing->image_pembayaran = null;
                $billing->file_pembayaran = $relative_path;
            }else{
                $dir = public_path().'/storage/app/listings/billings/'.$billing->id . '/';
                $file = $request->file('image');
                $file_name = preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
                $relative_path = 'storage/app/listings/billings/' . $billing->id . '/' .$file_name;

                if(!File::exists(public_path().'/storage/app/listings/billings/'.$billing->id)) {
                    $createDir = File::makeDirectory( public_path().'/storage/app/listings/billings/'.$billing->id,  0755, true);
                }

                Image::make($request->file('image'))->save($dir . $file_name);

                $billing->file_pembayaran = null;
                $billing->image_pembayaran = $relative_path;
            }
        }

        $billing->save();
        if($request->input('edit') == 'true')
            return view('customer.pages.billings.view', ['billing' => $billing]);
        else
            return redirect()->back()->withSuccess('success', 'Payment confirmed success!');
    }

    public function delimage($id){
        $billing = Billing::find($id);
        if($billing->image_pembayaran == NULL)
            $billing->file_pembayaran = NULL;
        else
            $billing->image_pembayaran = NULL;
        
        $billing->save();

        return redirect()->back()->withSuccess('success', 'Image deleted success!');
    }

    public function edit_confirm($id){
        $billing = Billing::find($id);

        if ($billing) {
            return view('customer.pages.billings.edit', ['billing' => $billing, 'edit' =>true]);
        }
    }
}
