<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Models\Customer;
use App\Models\Address;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('created_at', 'DESC')->paginate(15);

        return view('backend.pages.customers.list', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->get()->can('can_create_customer')) {
            return redirect()->back()->with('error', 'Permission denied!');
        }

        return view('backend.pages.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'customer_name' => 'required|max:100',
            'address_1' => 'required|max:255',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'phone' => 'required|numeric',
            'picphone' => 'required|numeric',
            'fax' => 'numeric',
            'picmobile1' => 'required|numeric',
            'picmobile2' => 'numeric',
            'picemail' => 'required|max:255|unique:customers,pic_email',
            'password' => 'required|min:6',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $customer = new Customer;
        $customer_count = (int)Customer::count() + 1;
        $original_cust_id = '01'.date('Y').date('m') . str_pad((string)$customer_count, 4, 0, STR_PAD_LEFT);
        $customer->customer_id =  $original_cust_id . substr(crc32($original_cust_id), -3);
        $customer->customer_name = $request->input('customer_name');
        $customer->phone = $request->input('phone');
        $customer->fax = $request->input('fax');
        $customer->pic = $request->input('pic');
        $customer->pic_phone = $request->input('picphone');
        $customer->pic_mobile1 = $request->input('picmobile1');
        $customer->pic_mobile2 = $request->input('picmobile2');
        $customer->pic_email = $request->input('picemail');
        $customer->password = bcrypt($request->input('password'));

        if ($customer->save()) {
            $address = new Address;
            $address->customer_id = $customer->id;
            $address->company = $customer->customer_name;
            $address->address_1 = $request->input('address_1');
            $address->address_2 = $request->input('address_2');
            $address->city = $request->input('city');
            $address->postcode = $request->input('postcode');
            $address->country_id = $request->input('country');
            $address->zone_id = $request->input('province');

            $address->save();

            $customer->address_id = $address->address_id;
            $customer->save();

            add_system_log(Auth::user()->get()->id, '<a href="javascript:;" class="name">' . Auth::user()->get()->name . '</a> created customer <a href="javascript:;" class="name">' . $customer->customer_name . '</a>');
            return redirect('app-admin/customers')->with('success', 'Customer created success.');
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
        $customer = Customer::find($id);

        if ($customer) {
            return view('backend.pages.customers.edit', ['customer' => $customer]);
        }

        return abort(404);
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
        
        $rules = [
            'customer_name' => 'required|max:100',
            'address_1' => 'required|max:255',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'phone' => 'required|numeric',
            'picphone' => 'required|numeric',
            'fax' => 'numeric',
            'picmobile1' => 'required|numeric',
            'picmobile2' => 'numeric',
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
            $customer->fax = $request->input('fax');
            $customer->pic = $request->input('pic');
            $customer->pic_phone = $request->input('picphone');
            $customer->pic_mobile1 = $request->input('picmobile1');
            $customer->pic_mobile2 = $request->input('picmobile2');
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
                $address->zone_id = $request->input('province');

                $address->save();

                add_system_log(Auth::user()->get()->id, '<a href="javascript:;" class="name">' . Auth::user()->get()->name . '</a> updated customer <a href="javascript:;" class="name">' . $customer->customer_name . '</a>');
                return redirect('app-admin/customers/edit/'.$customer->id)->with('success', 'Customer updated success.');
            }
        }

        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer_name = $customer->customer_name;

            $customer->delete();

            add_system_log(Auth::user()->get()->id, '<a href="javascript:;" class="name">' . Auth::user()->get()->name . '</a> Deleted customer <a href="javascript:;" class="name">' . $customer_name . '</a>');

            return redirect('app-admin/customers')->with('success', 'Customer deleted success.');
        }

        return abort(404);
    }
}
