<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $fillable = [
        'category_id', 'question', 'order', 'visibility',
    ];

    public function category(){
        return $this->belongsTo(\App\Questiontype::class, 'category_id','id');
    }

    public function answers(){
        return $this->hasMany(\App\Answers::class, 'question_id','id')->orderby('order','asc')->whereNull('is_deleted');
    }
}
