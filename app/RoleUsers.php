<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUsers extends Model
{
    protected $table = "role_user";
    public $timestamps = false;
    public function role(){
        return $this->belongsTo(\App\Role::class, 'role_id');
    }
}
