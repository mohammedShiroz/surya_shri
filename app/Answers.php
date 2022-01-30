<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    protected $fillable = [
        'question_id', 'answer','type', 'order', 'visibility',
    ];

    public function question()
    {
        return $this->belongsTo(\App\Questions::class, 'question_id','id');
    }
}
