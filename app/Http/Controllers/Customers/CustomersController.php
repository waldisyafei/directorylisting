<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
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
    public function update_info(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'required|confirmed|min:6',
            ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        /*if ($request->input('role') == 'choose-role' || $request->input('role') === null) {
            return redirect()->back()->with('error', 'Please select role for this user');
        }*/

        $customer = Customer::find($id);

        if ($customer) {
            $customer->customer_name = $request->input('name');
            $customer->pic_email = $request->input('email');
            $customer->password = bcrypt($request->input('password'));

            if ($customer->save()) {
                // Attach role to user
                //$customer->roles()->attach($request->input('role'));

                return redirect('account/edit_info')->with('success', 'User updated success.');
            }
        }
    }
}