<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function index(){

        return view('pages.wish_list.index',[
            'products'=> \App\Products::where('status','PUBLISHED')->where('visibility',1)->whereIn('id',\App\Wishlist::where('user_id', \auth::user()->id)->pluck('product_id')->toArray())->orderby('created_at','DESC')->get(),
            'services'=> \App\Service::where('status','Available')->where('visibility',1)->whereIn('id',\App\Wishlist::where('user_id', \auth::user()->id)->pluck('service_id')->toArray())->orderby('created_at','DESC')->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $status='add';
        //:check the product already in the list
        if (!\App\Wishlist::where('product_id', $request->id)->where('user_id', \auth::user()->id)->first()) {
            \App\Wishlist::create([
                    'user_id' => \auth::user()->id,
                    'product_id' => $request->id,
                ]);
            $status = 'add';
        }else{
            \App\Wishlist::where('user_id',\auth::user()->id)->where('product_id',$request->id)->delete();
            $status = 'delete';
        }
        return response()->json([
            'count' => \App\Wishlist::where('user_id',\auth::user()->id)->get()->count(),
            'status' => $status,
        ]);
    }

    public function store_service(Request $request)
    {
        //:check the product already in the list
        if (!\App\Wishlist::where('service_id', $request->id)->where('user_id', \auth::user()->id)->first()) {
            \App\Wishlist::create([
                'user_id' => \auth::user()->id,
                'service_id' => $request->id,
            ]);
        }
        return response()->json(['count' => \App\Wishlist::where('user_id',\auth::user()->id)->get()->count()]);
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

    public function destroy($id)
    {
        //:check the product already in the list
        if (\App\Wishlist::where('product_id', $id)->where('user_id', \Auth::user()->id)->first()) {
            \App\Wishlist::where('user_id', \Auth::user()->id)->where('product_id',$id)->delete();
        }
        $wish_list_product_ids=\App\Wishlist::where('user_id', \Auth::user()->id)->pluck('product_id')->toArray();
        return \Response::json([
            'count' => \App\Wishlist::where('user_id',\auth::user()->id)->get()->count(),
            'items_view' => view('components.wish_list.data_fetch',[
                'products'=> \App\Products::where('status','PUBLISHED')->where('visibility',1)->whereIn('id',\App\Wishlist::where('user_id', \auth::user()->id)->pluck('product_id')->toArray())->orderby('created_at','DESC')->get(),
                'services'=> \App\Service::where('status','Available')->where('visibility',1)->whereIn('id',\App\Wishlist::where('user_id', \auth::user()->id)->pluck('service_id')->toArray())->orderby('created_at','DESC')->get(),
            ])->render(),
        ]);
    }

    public function destroy_service($id)
    {
        //:check the product already in the list
        if (\App\Wishlist::where('service_id', $id)->where('user_id', \auth::user()->id)->first()) {
            \App\Wishlist::where('user_id', \auth::user()->id)->where('service_id',$id)->delete();
        }
        $list_service_ids=\App\Wishlist::where('user_id', \auth::user()->id)->pluck('service_id')->toArray();
        return \Response::json([
            'count' => \App\Wishlist::where('user_id',\auth::user()->id)->get()->count(),
            'items_view' => view('components.wish_list.data_fetch',[
                'products'=> \App\Products::where('status','PUBLISHED')->where('visibility',1)->whereIn('id',\App\Wishlist::where('user_id', \auth::user()->id)->pluck('product_id')->toArray())->orderby('created_at','DESC')->get(),
                'services'=> \App\Service::where('status','Available')->where('visibility',1)->whereIn('id',\App\Wishlist::where('user_id', \auth::user()->id)->pluck('service_id')->toArray())->orderby('created_at','DESC')->get(),
            ])->render(),
        ]);
    }

    public function destory_all_wish_list_products(){
        //:check the product already in the list
        \App\Wishlist::whereIn('user_id', [\Auth::user()->id])->delete();
        return \Response::json([
            'count' => \App\Wishlist::where('user_id',\auth::user()->id)->get()->count(),
            'items_view' => view('components.wish_list.data_fetch',[
                'products'=> \App\Products::where('status','PUBLISHED')->where('visibility',1)->whereIn('id',\App\Wishlist::where('user_id', \auth::user()->id)->pluck('product_id')->toArray())->orderby('created_at','DESC')->get(),
                'services'=> \App\Service::where('status','Available')->where('visibility',1)->whereIn('id',\App\Wishlist::where('user_id', \auth::user()->id)->pluck('service_id')->toArray())->orderby('created_at','DESC')->get(),
            ])->render(),
        ]);
    }
}
