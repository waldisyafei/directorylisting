<?php

use App\Models\Billing;
use App\Models\Invoice;

function create_billing($customer_id, $item_id, $item_type, $amount, $user_cat, $invoice)
{
	$billing = new Billing;

	$billing->customer_id = $customer_id;
	$billing->user_category = $user_cat;
	$billing->invoice = $invoice;
	$billing->item_id = $item_id;
	$billing->item_type = $item_type;
	$billing->amount = $amount;

	if ($billing->save()) {
		return true;
	}
}

function create_invoice($customer_id, $item_id, $item_type, $amount, $user_cat, $invoiceno)
{
	$invoice = new Invoice;

	$invoice->customer_id = $customer_id;
	// $invoice->user_category = $user_cat;
	$invoice->invoice_number = $invoiceno;
	$invoice->item_id = $item_id;
	// $invoice->item_type = $item_type;
	$invoice->amount = $amount;

	if ($invoice->save()) {
		return true;
	}
}