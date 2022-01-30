<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller_payments extends Model
{
    protected $fillable = [
        'partner_id','user_id', 'type', 'order_id', 'product_id','booking_id','service_id', 'paid_amount', 'payment_status'
    ];

    public function product() {
        return $this->belongsTo(\App\Products::class,'product_id');
    }

    public function order() {
        return $this->belongsTo(\App\Orders::class, 'order_id');
    }

    public function partner(){
        return $this->belongsTo(\App\Agent::class, 'partner_id','id');
    }
}
