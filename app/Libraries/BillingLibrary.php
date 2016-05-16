<?php
namespace App\Libraries;

use App\Models\Billing;

class BillingLibrary
{
	
	public static function create($customer_id, $item_id, $item_type, $amount)
	{
		$billing = new Billing;

		$billing->customer_id = $customer_id;
		$billing->item_id = $item_id;
		$billing->item_type = $item_type;
		$billing->amount = $amount;

		if ($billing->save()) {
			return $billing;
		}
	}

}