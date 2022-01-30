<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emp_friends_invite extends Model
{
    protected $fillable = [
        'agent_id', 'user_id',
    ];
}
