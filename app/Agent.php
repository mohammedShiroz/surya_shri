<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'user_id', 'ref_id', 'intro_id','placement_id'
    ];

    // One level parent
    public function parent()
    {
        return $this->belongsTo(self::class, 'placement_id');
    }

    public function parents() {
        if($this->parent && $this->parent->id !=1) {
                return $this->parent->parents(). "," . $this->id;
        } else {
            return $this->id;
        }
    }

    public function parents_without_user() {
        if($this->parent) {
            return ($this->parent->id !=1)? '1,'.$this->parent->parents(). ",": "1";
        } else {
            return $this->id;
        }
    }

    public function child_employees()
    {
        return $this->hasMany(self::class, 'placement_id', 'id');
    }

    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function referral_info(){
        return $this->belongsTo(self::class, 'ref_id');
    }

    public function intro_info(){
        return $this->belongsTo(self::class, 'intro_id');
    }

    public function placement_info(){
        return $this->belongsTo(self::class, 'placement_id');
    }

    public function products(){
        return $this->hasMany(\App\SellerProducts::class, 'agent_id');
    }

    public function services(){
        return $this->hasMany(\App\Service::class, 'doctor_id');
    }

    public function invited_friends(){
        return $this->hasMany(\App\Emp_friends_invite::class, 'agent_id');
    }

    public function vouchers(){
        return $this->hasMany(\App\Partner_vouchers::class, 'agent_id')->WhereNull('is_deleted');
    }

    public function joined_coupon(){
        return $this->hasMany(\App\UsedUserCoupons::class,'partner_id')
            ->orderby('created_at','DESC')
            ->whereNull('is_deleted');
    }
}
