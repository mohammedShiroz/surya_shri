<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerProducts extends Model
{
    protected $fillable = [
        'agent_id', 'product_id'
    ];

    public function product_info(){
        return $this->belongsTo( \App\Products::class, 'product_id');
    }
}
