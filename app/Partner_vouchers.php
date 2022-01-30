<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner_vouchers extends Model
{
    protected $fillable = [
        'agent_id', 'voucher_id', 'g_code', 'status'
    ];

    public function partner(){
        return $this->belongsTo(\App\Agent::class, 'agent_id', 'id');
    }

    public function admin_voucher(){
        return $this->belongsTo(\App\Vouchers::class, 'voucher_id', 'id');
    }

}
