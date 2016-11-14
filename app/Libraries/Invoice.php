<?php
namespace App\Libraries;

use App\Models\Invoice;

class InvoiceLibrary
{
	
	public static function create($customer_id, $billing_id, $amount)
	{
		$invoice = new Invoice;

		$invoice->customer_id = $customer_id;
		$invoice->item_id = $item_id;
		$invoice->item_type = $item_type;
		$invoice->amount = $amount;

		if ($invoice->save()) {
			return $invoice;
		}
	}

}