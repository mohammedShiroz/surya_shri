<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingAdditionalNotes extends Model
{
    protected $fillable = ['id', 'booking_id', 'additional', 'is_deleted', 'created_at', 'updated_at'];

    function booking(){
        return $this->belongsTo(\App\Service_booking::class,'booking_id');
    }
}
