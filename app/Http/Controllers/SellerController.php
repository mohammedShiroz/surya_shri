<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Observers\ActivityLogObserver;

class SellerController extends Controller
{

    public function __construct()
    {
        \App\Agent::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Agent(),
            'property' => ['name' => 'Check Sellers List'],
            'type' => 'Read',
            'log' => 'Check Sellers List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.sellers.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           'agent_id' => 'required'
        ]);

        if(\auth::user()->haspermission(['create-sellers','update-sellers'])) {
            \App\Agent::where('id', $request->input('agent_id'))->update([
                'is_seller' => Carbon::now()
            ]);
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Agent(),
                'property' => \App\Agent::find($request->agent_id),
                'type' => 'Create',
                'log' => 'Appointed a seller Appointed By ' . \Auth::user()->name,
            ]));
            return redirect()->back()->with('success', \App\Agent::where('id', $request->agent_id)->first()->user->name . " - is now appointed as seller.");
        }
        abort(403);
    }

    public function add_seller_product(Request $request){
        $this->validate($request,[
            'agent_id' => 'required',
            'product_id' => 'required',
        ]);
        \App\Products::where('id',$request->product_id)->update([
           'seller_id' => $request->agent_id,
        ]);
        \App\SellerProducts::create($request->all());
        return redirect()->back()->with('success', \App\Agent::where('id',$request->agent_id)->first()->user->name."'s product has been added.");
    }

    public function remove_seller_product(Request $request){
        $this->validate($request,[
            'agent_id' => 'required',
            'product_id' => 'required',
        ]);
        \App\Products::where('id',$request->product_id)->update([
            'is_deleted' => \Carbon\Carbon::now(),
        ]);
        \App\SellerProducts::WHERE('agent_id',$request->agent_id)->where('product_id',$request->product_id)->delete();
        return redirect()->back()->with('success', \App\Agent::where('id',$request->agent_id)->first()->user->name."'s product has been removed.");
    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Agent(),
            'property' => \App\User::find($id),
            'type' => 'Read',
            'log' => 'Check Seller Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.show',[
            'data' => \App\User::where('id',$id)->firstOrFail(),
        ]);
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
        \App\Agent::where('id',$id)->update([
            'is_seller' => Null,
            'is_doctor' => Null,
        ]);
        foreach(\App\SellerProducts::WHERE('agent_id',$id)->get() as $row){
            \App\SellerProducts::WHERE('agent_id',$row->agent_id)->delete();
            if(\App\Products::WHERE('seller_id',$row->agent_id)->firstOrFail()) {
                \App\Products::WHERE('seller_id', $row->agent_id)->update(['is_deleted' => \Carbon\Carbon::now()]);
            }
        }
        return redirect()->back()->with('success', \App\Agent::where('id',$id)->first()->user->name." - Doctor/Seller approve removed.");
    }
}
