<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    protected $fillable = [
        'name', 'description', 'code', 'voucher_type', 'discount_type', 'discount', 'minimum_total', 'allowed_users', 'allow_type', 'expiry_date', 'status', 'is_deleted'
    ];

    public function customers(){
        return $this->hasMany(\App\Voucher_customers::class, 'voucher_id','id')->orderby('created_at','desc');
    }
}
