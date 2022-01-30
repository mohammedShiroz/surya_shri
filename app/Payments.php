<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'user_id', 'type', 'order_id', 'booking_id', 'transaction_id', 'payment_method', 'paid_amount', 'paid_points', 'payment_status', 'payment_signature'
    ];

    public function user(){
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function order(){
        return $this->belongsTo(\App\Orders::class,'order_id');
    }

    public function booking(){
        return $this->belongsTo(\App\Service_booking::class,'booking_id');
    }
}
