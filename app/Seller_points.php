<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller_points extends Model
{
    protected $fillable = [
        'user_id','agent_id', 'type', 'order_id', 'product_id','booking_id','service_id', 'qty', 'amount', 'earn_points', 'created_at', 'updated_at'
    ];

    public function user(){
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function partner(){
        return $this->belongsTo(\App\Agent::class,'agent_id');
    }

    public function order(){
        return $this->belongsTo(\App\Orders::class,'order_id');
    }

    public function product(){
        return $this->belongsTo(\App\Products::class,'product_id');
    }

    public function booking(){
        return $this->belongsTo(\App\Service_booking::class,'booking_id');
    }
}
