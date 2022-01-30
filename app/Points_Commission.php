<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Points_Commission extends Model
{

    use Notifiable;

    protected $fillable =[
        'agent_id', 'feature_partner_user_id', 'user_id', 'type' ,'order_id', 'product_id', 'booking_id' ,'service_id','commission_user_id', 'commission_points','amount', 'pay_type', 'week'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id','id');
    }

    public function commission_user()
    {
        return $this->belongsTo(\App\User::class, 'commission_user_id','id');
    }

    public function order() {
        return $this->belongsTo(\App\Orders::class, 'order_id','id');
    }

    public function product() {
        return $this->belongsTo(\App\Products::class,'product_id');
    }

    public function partner() {
        return $this->belongsTo(\App\Agent::class,'agent_id','id');
    }

    public function booking() {
        return $this->belongsTo(\App\Service_booking::class, 'booking_id','id');
    }

    public function service() {
        return $this->belongsTo(\App\Service::class,'service_id');
    }

    public function featureUser()
    {
        return $this->belongsTo(\App\User::class, 'feature_partner_user_id','id');
    }
}
