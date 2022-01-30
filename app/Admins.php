<?php

namespace App;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laratrust\Traits\LaratrustUserTrait;

class Admins extends Authenticatable
{
    use SoftDeletes, Notifiable;
    use LaratrustUserTrait;

    public $table = 'admins';
    protected $guard = 'admins';
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'two_factor_expires_at',
    ];
    protected $fillable = [
        'name', 'email','contact', 'password', 'job_title', 'created_at', 'updated_at', 'remember_token', 'two_factor_code', 'two_factor_expires_at',
    ];

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 6);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function activity()
    {
        return $this->hasMany( \App\ActivityLog::class, 'causer_id');
    }

    public function role_user(){
        return $this->belongsTo(\App\RoleUsers::class ,'id','user_id');
    }
}
