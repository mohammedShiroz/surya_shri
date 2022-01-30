<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawalDetails extends Model
{
    protected $fillable = ['id', 'type', 'minimum_limit', 'maximum_limit', 'fee_amount', 'percentage', 'created_at', 'updated_at'];
}
