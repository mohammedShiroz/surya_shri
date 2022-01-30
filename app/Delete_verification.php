<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delete_verification extends Model
{
    protected $fillable = [
        'type', 'two_factor_code', 'two_factor_expires_at', 'user_id', 'created_at', 'updated_at'
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'two_factor_expires_at',
    ];
}
