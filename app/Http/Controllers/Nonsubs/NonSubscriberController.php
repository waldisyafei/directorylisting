<?php

namespace App\Http\Controllers\Nonsubs;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Models\Customer;

/**
* 
*/
class NonSubscriberController extends Controller
{
	
	function __construct()
	{
		$this->middleware('authNonSubscriber');
	}

	public function index()
	{
		return view('nonSubscriber.pages.dashboard');
	}

	/*public function sub_account()
	{
		$accounts = Customer::where('root', '!=', '0');

		return view('customer.pages.sub-account.list', ['accounts' => $accounts]);
	}*/
}