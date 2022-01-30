<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCouponCode extends Model
{
    protected $table = 'user_coupon_codes';
    protected $fillable = ['id', 'user_id', 'code', 'is_deleted', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id','id');
    }

    public function joined_ref(){
        return $this->hasMany(\App\UsedUserCoupons::class, 'coupon_id')->whereNull('is_deleted');;
    }
}
