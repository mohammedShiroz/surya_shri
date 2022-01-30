<?php

namespace App;

use Laratrust\Models\LaratrustPermission;
use Laratrust\Traits\LaratrustPermissionTrait;

class Permission extends LaratrustPermission
{
    use LaratrustPermissionTrait;
    public $guarded = ['admins'];

    protected $fillable = ['id', 'name', 'display_name', 'description', 'created_at', 'updated_at'];
}

