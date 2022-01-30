<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment_notify extends Model
{
    protected $fillable = [
        'merchant_id', 'order_id', 'payhere_amount', 'payhere_currency', 'status_code', 'md5sig'
    ];
}
