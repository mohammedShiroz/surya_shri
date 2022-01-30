<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sellers_additional_notes extends Model
{
    protected $fillable = ['id', 'user_id', 'additional', 'is_deleted','created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }
}
