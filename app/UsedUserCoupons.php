<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsedUserCoupons extends Model
{
    protected $table = 'used_user_coupons';
    protected $fillable = ['id', 'user_id', 'partner_id', 'coupon_id', 'user_code', 'order_id', 'booking_id', 'is_deleted', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id','id');
    }

    public function partner(){
        return $this->belongsTo(\App\Agent::class, 'partner_id','id');
    }

    public function coupon(){
        return $this->belongsTo(\App\UserCouponCode::class, 'coupon_id','id');
    }

    public function order(){
        return $this->belongsTo(\App\Orders::class, 'order_id','id');
    }

    public function booking(){
        return $this->belongsTo(\App\Service_booking::class, 'booking_id','id');
    }
}
