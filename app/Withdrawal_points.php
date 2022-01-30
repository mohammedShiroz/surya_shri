<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Withdrawal_points extends Model
{
    use Notifiable;


    protected $fillable = [
        'id', 'user_id', 'withdrawal_points', 'status', 'amount','fee_amount','reject_reason', 'transaction_id', 'week', 'given_date', 'rejected_at', 'reject_description', 'created_at', 'updated_at'
    ];

    public function user(){
        return $this->belongsTo(\App\User::class,'user_id');
    }
}
