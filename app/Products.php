<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'seller_id', 'answer_tags', 'is_featured', 'item_code', 'price', 'actual_price', 'discount_mode', 'discount_name','discount_price', 'discount_percentage', 'direct_commission', 'direct_commission_price', 'agent_pay_amount', 'first_level_commission', 'first_level_commission_price', 'second_level_commission', 'second_level_commission_price', 'third_level_commission', 'third_level_commission_price', 'fourth_level_commission', 'fourth_level_commission_price', 'fifth_level_commission', 'fifth_level_commission_price', 'bonus_commission', 'bonus_commission_price', 'expenses_commission', 'expenses_commission_price', 'donations_commission', 'donations_commission_price', 'seller_paid', 'seller_paid_amount', 'is_negotiable', 'is_deliverable', 'stock', 'sold', 'description', 'long_description', 'additional','image', 'thumbnail_image', 'status', 'order', 'visibility', 'is_deleted',
    ];

    public function category(){
        return $this->belongsTo(\App\Product_category::class, 'category_id');
    }

    public function questions(){
        return $this->hasMany(\App\Product_Questions_Answers::class, 'product_id','id');
    }

    public function seller_info(){
        return $this->belongsTo(\App\Agent::class, 'seller_id','id');
    }

    public function reviews(){
        return $this->hasMany(\App\Product_reviews::class, 'product_id','id')
            ->WhereNull('is_deleted')
            ->orderBy('created_at','DESC');
    }

    public function rate(){
        return $this->hasMany(\App\Product_rate::class, 'product_id','id');
    }

    public function images(){
        return $this->hasMany(\App\Product_images::class, 'product_id','id');
    }

}
