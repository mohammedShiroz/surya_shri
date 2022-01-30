<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Points extends Model
{
    use Notifiable;

    protected $fillable =[
        'user_id', 'order_id', 'booking_id', 'direct_points', 'in_direct_points', 'forward_points', 'forward_user_id', 'transferred_points', 'transferred_user_id', 'week'
    ];

    public function user_info()
    {
        return $this->belongsTo(\App\User::class, 'user_id','id');
    }

    public function forward_user_info()
    {
        return $this->belongsTo(\App\User::class, 'forward_user_id','id');
    }

    public function order()
    {
        return $this->belongsTo(\App\Orders::class, 'order_id','id');
    }

    public function booking()
    {
        return $this->belongsTo(\App\Service_booking::class, 'booking_id','id');
    }
}
