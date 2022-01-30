<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReviewReply extends Model
{
    protected $fillable = ['id', 'review_id', 'user_id', 'comments', 'status','is_deleted', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(\App\Admins::class, 'user_id');
    }
}
