<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Service_booking extends Model
{
    use Notifiable;

    protected $fillable = [
        'book_reference', 'service_id','type', 'user_id', 'book_date', 'book_time', 'old_book_date', 'voucher_id', 'coupon_id', 'old_book_time', 'price', 'payment_method', 'paid_amount','paid_points', 'status', 'confirmed_date', 'canceled_date', 'rejected_date','reject_reason','is_confirmed','is_deleted'
    ];

    public function service(){
        return $this->belongsTo( \App\Service::class,'service_id','id');
    }

    public function user(){
        return $this->belongsTo( \App\User::class,'user_id','id');
    }

    public function customer(){
        return $this->belongsTo( \App\Service_booking_customer::class,'id','booking_id');
    }

    public function payment(){
        return $this->belongsTo( \App\Payments::class, 'id','booking_id');
    }

    public function notes()
    {
        return $this->hasMany(\App\BookingAdditionalNotes::class, 'booking_id');
    }
}
