<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_category extends Model
{
    protected $fillable =[
        'parent_id', 'name', 'slug', 'image', 'order', 'description', 'visibility',
    ];

    public function parent() {
        return $this->belongsTo(self::class,'parent_id','id');
    }

    public function children() {
        return $this->hasMany(self::class,'parent_id','id')->WhereNull('is_deleted');
    }

    public function products() {
        return $this->hasMany(\App\Products::class,'category_id','id')->WhereNull('is_deleted');
    }

    public function category_products() {
        return $this->hasManyThrough( \App\Products::class, self::class, 'parent_id', 'category_id')->WhereNull('products.is_deleted');
    }

//
    public function childrenRecursive() {
        return $this->children()->with('children');
    }

}
