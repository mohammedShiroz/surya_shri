<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function create(Request $request)
    {
        $data = \App\Products::find($request->product_id);
        $product_qty = $request->product_qty;
        $product_image = asset(($data->thumbnail_image)? $data->thumbnail_image : 'assets/images/product_img_none/no_product_img.jpg' );
        //:check previous cart product's qty
        $check_qty=0;
        if(\Cart::instance('shopping')->content()->count()>0){
            foreach (\Cart::instance('shopping')->content()  as $cart_item){
                if($cart_item->id == $data->id){
                    $check_qty=$cart_item->qty;
                }
            }
        }
        if (get_stock($data->id) < ((int)$product_qty + $check_qty)) {
            return response()->json('invalid_stock');
        } else {
            //:Add cart info
            \Cart::instance('shopping')->add($data->id, $data->name, $product_qty, $data->price, [
                'img' => $product_image,
                'seller_id' => $data->seller_id,
                'seller_name' => $data->seller_info->user->name,
                'category' => $data->category->name,
                'category_id' => $data->category_id,
                'stock' => get_stock($data->id),
                'item_slug' => $data->slug,
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
                'third_level_commission' => $data->third_level_commission,
                'third_level_commission_price' => $data->third_level_commission_price,
                'fourth_level_commission' => $data->fourth_level_commission,
                'fourth_level_commission_price' => $data->fourth_level_commission_price,
                'fifth_level_commission' => $data->fifth_level_commission,
                'fifth_level_commission_price' => $data->fifth_level_commission_price,
                'bonus_commission' => $data->bonus_commission,
                'bonus_commission_price' => $data->price,
                'expenses_commission' => $data->expenses_commission,
                'expenses_commission_price' => $data->expenses_commission,
                'seller_paid' => $data->seller_paid,
                'seller_paid_amount' => $data->seller_paid_amount,
            ]);
        }
        return view('components.nav_bar.cart')->render();
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update()
    {
        return response()->json([
            'shopping_cart_view'=> view('components.cart.fetch_cart_items')->render(),
            'nav_bar_view' =>view('components.nav_bar.cart')->render(),
        ]);
    }

    public function destroy($id)
    {
        $item_name = \Cart::instance('shopping')->get($id)->name;
        \Cart::instance('shopping')->remove($id);
        return response()->json([
            'cart_view' => view('components.nav_bar.cart')->render(),
            'shopping_cart_view'=> view('components.cart.fetch_cart_items')->render(),
            'item_name' => $item_name,
        ]);
    }

    public function remove_shopping_cart_item($id){
        $item_name = \Cart::instance('shopping')->get($id)->name;
        //:Remove cart item
        \Cart::instance('shopping')->remove($id);
        return response()->json([
           'shopping_cart_view'=> view('components.cart.fetch_cart_items')->render(),
           'nav_bar_view' =>view('components.nav_bar.cart')->render(),
           'item_name' => $item_name,
        ]);
    }

    public function remove_all_shopping_cart_item(){
        //:Remove cart item
        \Cart::instance('shopping')->destroy();
        return response()->json([
            'shopping_cart_view'=> view('components.cart.fetch_cart_items')->render(),
            'nav_bar_view' =>view('components.nav_bar.cart')->render(),
        ]);
    }

    public function update_cart_qty($id, $qty)
    {
        $cart_item = \Cart::instance('shopping')->get($id);
        $data =\App\Products::find($cart_item->id);
        $chk_stock=get_stock($data->id);
        if($chk_stock >= $qty) {
            \Cart::instance('shopping')->update($id, $qty);
        }else{
            return response()->json('invalid_stock');
        }
        return response()->json([
            'shopping_cart_view'=> view('components.cart.fetch_cart_items')->render(),
            'nav_bar_view' =>view('components.nav_bar.cart')->render(),
        ]);
    }
}
