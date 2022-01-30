<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund_points extends Model
{
    protected $fillable = [
        'user_id', 'booking_id', 'order_id', 'refund_points'
    ];

    public function order(){
        return $this->belongsTo(\App\Orders::class,'order_id');
    }

    public function booking(){
        return $this->belongsTo(\App\Service_booking::class,'booking_id');
    }
}
