<?php

use App\Models\Billing;

function create_billing($customer_id, $item_id, $item_type, $amount, $user_cat)
{
	$billing = new Billing;

	$billing->customer_id = $customer_id;
	$billing->user_category = $user_cat;
	$billing->item_id = $item_id;
	$billing->item_type = $item_type;
	$billing->amount = $amount;

	if ($billing->save()) {
		return true;
	}
}