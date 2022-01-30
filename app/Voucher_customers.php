<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Voucher_customers extends Model
{
    use Notifiable;
    protected $fillable = [
        'voucher_id','user_id', 'order_id','booking_id','redeem_id'
    ];

    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function voucher(){
        return $this->belongsTo(\App\Vouchers::class, 'voucher_id', 'id');
    }

    public function order(){
        return $this->belongsTo(\App\Orders::class, 'order_id', 'id');
    }

    public function booking(){
        return $this->belongsTo(\App\Service_booking::class, 'booking_id', 'id');
    }

    public function redeem(){
        return $this->belongsTo(\App\RedeemPoints::class, 'redeem_id', 'id');
    }
}
