<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAdditionalNotes extends Model
{
    protected $fillable = ['id', 'order_id', 'additional', 'is_deleted', 'created_at', 'updated_at'];

    public function order()
    {
        return $this->belongsTo(\App\Orders::class,'order_id');
    }
}
