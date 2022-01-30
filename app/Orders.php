<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Orders extends Model
{
    use Notifiable;

    protected $fillable = [
        'user_id', 'track_id', 'payment_method', 'payment_status', 'total', 'shipping_amount', 'voucher_id','coupon_id', 'status','reject_reason', 'cancel_reason', 'delivery_method' ,'pre_address' ,'delivery_status', 'is_deleted', 'confirmed_date', 'rejected_date', 'canceled_date','delivery_date', 'delivery_send_date', 'additional'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(\App\Order_Customer_data::class, 'id','order_id');
    }

    public function items()
    {
        return $this->hasMany(\App\Order_items::class, 'order_id');
    }

    public function payment()
    {
        return $this->belongsTo(\App\Payments::class, 'id','order_id');
    }

    public function vouchers()
    {
        return $this->belongsTo(\App\Voucher_customers::class, 'id', 'order_id');
    }

    public function notes()
    {
        return $this->hasMany(\App\OrderAdditionalNotes::class, 'order_id');
    }
}
