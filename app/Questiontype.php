<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questiontype extends Model
{
    protected $fillable = [
        'parent_id', 'name', 'slug', 'image', 'order', 'description', 'visibility',
    ];
}
