<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_images extends Model
{
    protected $fillable = [
        'id', 'product_id', 'image_thumbnail', 'image', 'order', 'is_deleted', 'created_at', 'updated_at'
    ];

    public function product(){
        return $this->belongsTo(\App\Products::class, 'product_id');
    }
}
