<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customers_answers extends Model
{
    use Notifiable;
    protected $fillable = [
        'user_id', 'answer_ids','question_count','vata','pitta','kapha','is_deleted'
    ];

    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
