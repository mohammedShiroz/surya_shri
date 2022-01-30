<?php

namespace App\Http\Controllers;

use App\Vouchers;
use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class VouchersController extends Controller
{
    public function __construct()
    {
        \App\Vouchers::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Vouchers(),
            'property' => ['name' => 'Check Created Vouchers List'],
            'type' => 'Read',
            'log' => 'Check Created Vouchers List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.vouchers.index');
    }

    public function create()
    {
        return view('backend.vouchers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'code' => 'required',
            'voucher_type' => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
            'status' => 'required'
        ]);
        $table=\App\Vouchers::create($request->all());
        if($request->voucher_expiry_date){
            $table->expiry_date = date('Y-m-d',strtotime($request->voucher_expiry_date));
            $table->save();
        }
        return redirect()->back()->with('success', $request->name." - voucher has been created.");
    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Vouchers(),
            'property' => \App\Vouchers::find($id),
            'type' => 'Read',
            'log' => 'Check Voucher Details Read By ' . \Auth::user()->name,
        ]));

        return view('backend.vouchers.view')->with(
            ['data' => \App\Vouchers::find($id)]
        );

    }

    public function edit($id)
    {
        return view('backend.vouchers.edit')->with(
            ['data' => \App\Vouchers::find($id)]
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'code' => 'required',
            'voucher_type' => 'required',
            'discount_type' => 'required',
            'discount' => 'required',
            'status' => 'required'
        ]);
        $table=\App\Vouchers::find($id);
        $table->update($request->all());
        if($request->voucher_expiry_date){
            $table->update(['expiry_date' => date('Y-m-d',strtotime($request->voucher_expiry_date))]);
        }else{
            $table->update(['expiry_date' => null]);
        }
        return redirect()->back()->with('success', $request->name." - voucher has been update.");
    }

    public function destroy($id)
    {
        $table=\App\Vouchers::where('id',$id)->first();
//        $table->update([
//            'is_deleted' => \Carbon\Carbon::now(),
//        ]);
        $table->delete();
        return redirect()->back()->with('success', $table->name." - voucher has been deleted.");
    }

    public function destroy_all(){
        foreach(\App\Vouchers::all() as $row){
            \App\Vouchers::find($row->id)->delete();
//            \App\Vouchers::find($row->id)->update(['is_deleted' => \Carbon\Carbon::now()]);
        }
        return redirect()->back()->with('success', "All vouchers has been cleared.");
    }
}
