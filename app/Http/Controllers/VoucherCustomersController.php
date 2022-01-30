<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class VoucherCustomersController extends Controller
{
    public function __construct()
    {
        \App\Voucher_customers::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Vouchers(),
            'property' => ['name' => 'Check Used Vouchers List'],
            'type' => 'Read',
            'log' => 'Check Used Vouchers List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.vouchers.customers.index');
    }

    public function create()
    {
        //
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

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $table = \App\Voucher_customers::find($id);
        $u_name =$table->user->name;
        $table->delete();
        return redirect()->back()->with('success', $u_name."'s  - voucher has been deleted.");
    }

    public function destroy_all(){

        \App\Voucher_customers::query()->truncate();
        return redirect()->back()->with('success', "All used voucher data has been cleared.");

    }
}
