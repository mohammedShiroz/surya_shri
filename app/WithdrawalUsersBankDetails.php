<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawalUsersBankDetails extends Model
{
    protected $fillable = ['id', 'user_id', 'account_name', 'account_number', 'bank_branch', 'bank_name', 'Remarks', 'billing_proof', 'nic_proof', 'is_deleted', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(\App\User::class,'user_id');
    }
}
