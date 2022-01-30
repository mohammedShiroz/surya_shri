<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User_address extends Model
{
    protected $fillable = [
        'user_id', 'address', 'postal_code'
    ];
}
