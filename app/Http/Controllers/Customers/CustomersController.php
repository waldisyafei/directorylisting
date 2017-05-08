<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Validator;
use App\Models\Address;
use App\Models\Customer;
use App\Models\Listing;
use Carbon\Carbon;

/**
* 
*/
class CustomersController extends Controller
{
	
	function __construct()
	{
		$this->middleware('authCustomer');
	}

	public function index()
	{
		return view('customer.pages.dashboard');
	}

	public function sub_account()
	{
		$accounts = Customer::where('root', '!=', '0');

		return view('customer.pages.account.sub-account.list', ['accounts' => $accounts]);
	}

	/**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit_info()
    {
        $customer = Customer::find(Auth::customer()->get()->id);
                    //var_dump($customer);die();

        if ($customer) {
            return view('customer.pages.account.edit', ['customer' => $customer]);
        }

        return abort(404, 'Request not found');
    }

    public function change_password()
    {
        $customer = Customer::find(Auth::customer()->get()->id);
                    //var_dump($customer);die();

        if ($customer) {
            return view('customer.pages.account.change_password', ['customer' => $customer]);
        }

        return abort(404, 'Request not found');
    }

    public function update_change_password(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
            ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $customer = Customer::find($id);

        if (!Hash::check($request->input('old_password'), $customer->password))
            return redirect()->back()->withInput()->withErrors('Existing password is not match');

        if ($customer) {
            $customer->password = bcrypt($request->input('password'));

            if ($customer->save()) {
                return redirect('account/change_password')->with('success', 'User\'s password  updated success.');
            }
        }
    }

    public function update_info(Request $request, $id)
    {
        
        $rules = [
            'customer_name' => 'required|max:100',
            'address_1' => 'required|max:255',
            'country' => 'required',
            //'province' => 'required',
            'city' => 'required',
            'phone' => 'required|numeric',
            'picphone' => 'required|numeric',
            //'fax' => 'numeric',
            //'picmobile1' => 'required|numeric',
            //'picmobile2' => 'numeric',
            'picemail' => 'required|max:255|unique:customers,pic_email,'.$id
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $customer = Customer::find($id);
        if ($customer) {
            //$customer_count = (int)Customer::count();
            //$customer->customer_id = '01'.date('Y').date('m') . str_pad((string)$customer_count, 4, 0, STR_PAD_LEFT);
            $customer->customer_name = $request->input('customer_name');
            $customer->phone = $request->input('phone');
            //$customer->fax = $request->input('fax');
            $customer->pic = $request->input('pic');
            $customer->pic_phone = $request->input('picphone');
            $customer->pic_mobile1 = $request->input('picmobile1');
            //$customer->pic_mobile2 = $request->input('picmobile2');
            $customer->pic_email = $request->input('picemail');

            if ($request->has('password') && $request->input('password') != ''){
                $customer->password = bcrypt($request->input('password'));
            }

            if ($customer->save()) {
                $address = Address::find($customer->address_id);
                $address->address_1 = $request->input('address_1');
                $address->address_2 = $request->input('address_2');
                $address->city = $request->input('city');
                $address->postcode = $request->input('postcode');
                $address->country_id = $request->input('country');
                //$address->zone_id = $request->input('province');

                $address->save();

                add_system_log(Auth::customer()->get()->id, '<a href="javascript:;" class="name">' . Auth::customer()->get()->name . '</a> updated customer <a href="javascript:;" class="name">' . $customer->customer_name . '</a>');
                return redirect('account/edit_info/')->with('success', 'Account info updated success.');
            }
        }

        return abort(404);
    }
}