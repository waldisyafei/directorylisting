<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'invoices';

    public function billing()
    {
    	return $this->hasOne('App\Models\Billing', 'invoice', 'invoice_number');
    }
}
