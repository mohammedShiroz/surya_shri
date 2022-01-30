<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //:check the service already in the list
        if (!\App\Favorites::where('service_id', $request->id)->where('user_id', \auth::user()->id)->first()) {
            \App\Favorites::create([
                'user_id' => \auth::user()->id,
                'service_id' => $request->id,
            ]);
        }
        return response()->json(['count' => \App\Favorites::where('user_id',\auth::user()->id)->get()->count()]);
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
        //:check the product already in the list
        if (\App\Favorites::where('service_id', $id)->where('user_id', \Auth::user()->id)->first()) {
            \App\Favorites::where('user_id', \auth::user()->id)->where('service_id',$id)->delete();
        }
        $list_services_ids=\App\Favorites::where('user_id', \auth::user()->id)->pluck('service_id')->toArray();
        return \Response::json([
            'count' => \App\Wishlist::where('user_id',\auth::user()->id)->get()->count(),
            'products_view' => view('components.products.products_data_fetch',[
                'products' => \App\Products::where('status','PUBLISHED')->where('visibility',1)->whereIn('id',$wish_list_product_ids)->orderby('created_at','DESC')->get(),
                'is_wish_list_available'=> true,
            ])->render(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
