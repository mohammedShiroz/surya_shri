<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [ 'id', 'category_id', 'doctor_id', 'name', 'service_code', 'tag_code', 'slug', 'thumbnail_image', 'image', 'description', 'long_description', 'buffer_time','form_type','price', 'actual_price', 'discount_mode', 'discount_price', 'discount_percentage', 'direct_commission', 'direct_commission_price', 'agent_pay_amount', 'first_level_commission', 'first_level_commission_price', 'second_level_commission', 'second_level_commission_price', 'third_level_commission', 'third_level_commission_price', 'fourth_level_commission', 'fourth_level_commission_price', 'fifth_level_commission', 'fifth_level_commission_price', 'bonus_commission', 'bonus_commission_price', 'expenses_commission', 'expenses_commission_price', 'donations_commission', 'donations_commission_price', 'seller_paid', 'seller_paid_amount', 'week_days', 'duration', 'duration_hour', 'duration_minutes', 'order', 'status', 'visibility',  'a_question_one', 'a_question_two', 'a_question_three', 'is_deleted', 'created_at', 'updated_at' ];

    public function category(){
        return $this->belongsTo(\App\Service_category::class, 'category_id','id');
    }

    public function doctor(){
        return $this->belongsTo(\App\Agent::class, 'doctor_id','id');
    }

    public function reviews(){
        return $this->hasMany(\App\Service_review::class, 'service_id','id')
            ->WhereNull('is_deleted')
            ->orderBy('created_at','DESC');
    }

    public function questions(){
        return $this->hasMany(\App\Service_questions_answers::class, 'service_id','id');
    }

    public function images(){
        return $this->hasMany(\App\Service_images::class, 'service_id','id');
    }
}
