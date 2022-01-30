<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_category extends Model
{
    protected $fillable = [
        'parent_id', 'name', 'slug', 'image', 'order','description','visibility'
    ];

    public function services(){
        return $this->hasMany(\App\Service::class, 'category_id')->where('visibility',1)->whereNull('is_deleted');
    }
}
