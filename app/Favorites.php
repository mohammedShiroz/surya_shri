<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $fillable = ['id', 'user_id', 'service_id', 'created_at', 'updated_at'];
}
