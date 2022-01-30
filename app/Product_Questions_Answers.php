<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_Questions_Answers extends Model
{
    protected $fillable = [
        'product_id', 'question_id', 'answer_id'
    ];

    public function question_info(){
        return $this->belongsTo(\App\Questions::class, 'question_id','id');
    }

    public function answer_info(){
        return $this->belongsTo(\App\Answers::class, 'answer_id','id');
    }
}
