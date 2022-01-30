<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service_booking_customer extends Model
{
    protected $fillable = [ 'id', 'booking_id', 'name', 'last_name', 'email', 'contact', 'nic', 'a_question_one', 'a_question_two', 'a_question_three', 'a_answer_one', 'a_answer_two', 'a_answer_three', 'note', 'created_at', 'updated_at' ];
}
