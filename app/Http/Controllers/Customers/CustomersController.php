<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Models\Customer;
use App\Models\Listing;

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

		return view('customer.pages.sub-account.list', ['accounts' => $accounts]);
	}
}