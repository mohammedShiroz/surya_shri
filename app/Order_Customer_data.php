<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_Customer_data extends Model
{
    protected $fillable = [
        'order_id', 'name', 'address', 'country', 'city', 'contact', 'email', 'note'
    ];
}
