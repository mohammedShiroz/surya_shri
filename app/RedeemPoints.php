<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemPoints extends Model
{
    protected $fillable = [ 'id', 'user_id', 'voucher_id', 'points', 'created_at', 'updated_at' ];

    public function user(){

        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function voucher(){

        return $this->belongsTo(\App\Vouchers::class, 'voucher_id');
    }
}
