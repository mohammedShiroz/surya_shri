<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ActivityLog extends Model
{
    use Notifiable;
    protected $table = 'activity_log';
    protected $fillable = ['id', 'log_name', 'description', 'subject_type', 'subject_id', 'causer_type', 'causer_id', 'properties', 'created_at', 'updated_at'];

    public function admin()
    {
        return $this->belongsTo(\App\Admins::class, 'causer_id');
    }
}
