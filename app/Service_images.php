<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_images extends Model
{
    protected $fillable = [
        'id', 'service_id', 'image_thumbnail', 'image', 'order', 'is_deleted', 'created_at', 'updated_at'
    ];

    public function service(){
        return $this->belongsTo(\App\Service::class, 'service_id');
    }
}
