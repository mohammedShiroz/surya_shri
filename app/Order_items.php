<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'qty', 'sub_total'
    ];

    public function product() {
        return $this->belongsTo(\App\Products::class,'product_id');
    }

    public function order() {
        return $this->belongsTo(\App\Orders::class, 'order_id');
    }
}
