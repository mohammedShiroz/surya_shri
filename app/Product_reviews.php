<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_reviews extends Model
{
    protected $fillable = [
        'product_id', 'user_id', 'name', 'comments','rate', 'status','is_deleted'
    ];

    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id','id');
    }

    public function reply(){

        return $this->hasMany(\App\ProductReviewReply::class, 'review_id','id')
            ->WhereNull('is_deleted');
    }
}
