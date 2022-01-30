<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_review extends Model
{
    protected $fillable = [
        'service_id', 'user_id', 'name', 'comments','rate', 'status','is_deleted'
    ];

    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id','id');
    }

    public function reply(){

        return $this->hasMany(\App\ServiceReviewReply::class, 'review_id','id')
            ->WhereNull('is_deleted');
    }
}
