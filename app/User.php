<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','last_name','user_name','user_code','gender','email','contact','password','e-subscribe','is_invited'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function address_info(){

        return $this->hasMany( \App\User_address::class, 'user_id','id')->WhereNull('is_deleted');
    }

    public function employee(){
        return $this->belongsTo(\App\Agent::class, 'agent_id');
    }

    public function ref_info(){
        return $this->belongsTo(\App\Agent::class, 'request_referral');
    }

    public function booking(){
        return $this->hasMany(\App\Service_booking::class, 'user_id','id')->whereNull('is_deleted')->orderby('created_at','DESC');
    }

    public function payments(){
        return $this->hasMany(\App\Payments::class, 'user_id','id')->orderby('created_at','DESC');
    }

    public function orders(){
        return $this->hasMany(\App\Orders::class, 'user_id','id')->orderby('created_at','DESC');
    }

    public function bookings(){
        return $this->hasMany(\App\Service_booking::class, 'user_id','id')->orderby('created_at','DESC');
    }

    public function wishlist(){
        return $this->hasMany(\App\Wishlist::class, 'user_id','id')->orderby('created_at','DESC');
    }

    public function notes(){
        return $this->hasMany(\App\sellers_additional_notes::class,'user_id')->orderby('created_at','DESC');
    }

    public function activity()
    {
        return $this->hasMany( \App\ActivityLog::class, 'causer_id')->where('causer_type','App\User')->orderby('id','ASC');
    }

    public function answer(){
        return $this->belongsTo(\App\Customers_answers::class, 'id','user_id');
    }

    public function bank_details(){
        return $this->belongsTo(\App\WithdrawalUsersBankDetails::class, 'id','user_id')->whereNull('is_deleted');
    }

    public function coupon_codes(){
        return $this->hasMany(\App\UserCouponCode::class, 'user_id', 'id')
            ->orderby('created_at','DESC')
            ->whereNull('is_deleted');
    }
}
