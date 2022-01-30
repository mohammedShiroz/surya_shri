<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    public function index()
    {
        return view('pages.products.comparison');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $status="success";
//        \Cart::instance('comparison')->destroy();

        $data = \App\Products::where('id', $request->id)->firstOrfail();
        $product_image = asset(($data->thumbnail_image)? $data->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg' );
        //:check previous product's info
        $all_item_ids=array();
        foreach(\Cart::instance('comparison')->content() as $item){
            array_push($all_item_ids, $item->id);
        }
        if(in_array($request->id,$all_item_ids,false)){
            $status="exist_item_identified";
        }
        else{
            \Cart::instance('comparison')->add($data->id, $data->name, 1, $data->price, [
                'img' => $product_image,
                'seller_id' => $data->seller_id,
                'seller_name' => $data->seller_info->user->name,
                'category' => $data->category->name,
                'category_id' => $data->category_id,
                'stock' => $data->stock,
                'pro_slug' => $data->slug,
                'actual_price' => $data->actual_price,
                'discount_price' => $data->discount_price,
                'discount_percentage' => $data->discount_percentage,
                'direct_commission' => $data->direct_commission,
                'direct_commission_price' => $data->direct_commission_price,
                'agent_pay_amount' => $data->agent_pay_amount,
                'first_level_commission' =>$data->first_level_commission,
                'first_level_commission_price' => $data->first_level_commission_price,
                'second_level_commission' => $data->second_level_commission,
                'second_level_commission_price' => $data->second_level_commission_price,
                'bonus_commission' => $data->bonus_commission,
                'bonus_commission_price' => $data->price,
                'expenses_commission' => $data->expenses_commission,
                'expenses_commission_price' => $data->expenses_commission,
                'seller_paid' => $data->seller_paid,
                'seller_paid_amount' => $data->seller_paid_amount,
                'description' => $data->description,
                'reviews_count' => $data->reviews->count(),
                'reviews_avg_rate' => $data->reviews->avg('rate'),
            ]);
        }
        return \Response::json([
            'status' =>$status,
            'comparison_count' => \Cart::instance('comparison')->content()->count(),
        ]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        \Cart::instance('comparison')->remove($request->id);
        return \Response::json([
            'status' => 'success',
            'comparison_count' => \Cart::instance('comparison')->content()->count(),
        ]);
    }

    public function destroy_all_comparison_items(){
        \Cart::instance('comparison')->destroy();
        return \Response::json([
            'status' => 'success',
            'comparison_count' => \Cart::instance('comparison')->content()->count(),
        ]);
    }
}
