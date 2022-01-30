<?php

use Carbon\Carbon;

function getCurrencyFormat($amount)
{
    $currency = array(
        'name' => 'Currency',
        'description' => 'LKR ',
    );
    $place =array(
        'name' => 'Currency Display Place',
        'description' => 'front',
    );
    $formatted_string = number_format($amount, 2, '.', ',');
    if (count($currency)) {
        if (count($place)) {
            if ($place['description'] === 'front') {
                return $currency['description'] . ' ' . $formatted_string;
            }
        }
        return $formatted_string . ' ' . $currency['description'];
    }
    return $formatted_string;
}

function getPointsFormat($point)
{
    $formatted_string = number_format($point, 1);
    return $formatted_string;
}

function getPlaceFormat($number)
{
    $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
    if (($number % 100) >= 11 && ($number % 100) <= 13)
        $abbreviation = $number . 'th';
    else
        $abbreviation = $number . $ends[$number % 10];
    return $abbreviation;
}

function make_slug($string){
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    return $slug;
}

function get_stock($product_id){
    $count_of_stock = \App\Products::find($product_id)->stock;
    foreach(\App\Order_items::where('product_id',$product_id)->get() as $row_item){
        if($row_item->order->status == "Pending"){
            $count_of_stock = $count_of_stock - $row_item->qty;
        }
    }
    return (($count_of_stock < 0) ? 0 : $count_of_stock );
}

function get_pending_stock($product_id){
    $count_of_stock = 0;
    foreach(\App\Order_items::where('product_id',$product_id)->get() as $row_item){
        if($row_item->order->status == "Pending"){
            $count_of_stock = $row_item->qty;
        }
    }
    return (($count_of_stock < 0) ? 0 : $count_of_stock );
}
