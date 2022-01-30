<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class SellerPaymentController extends Controller
{
    public function __construct()
    {
        \App\Seller_payments::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Seller_payments(),
            'property' => ['name' => 'Check Sellers Payments List'],
            'type' => 'Read',
            'log' => 'Check Sellers Payments List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.payments.sellers_payments.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Seller_payments(),
            'property' => \App\Seller_payments::find($id),
            'type' => 'Read',
            'log' => 'Check Seller Payment DetailsRead By ' . \Auth::user()->name,
        ]));

        return view('backend.payments.view',[
            'data' => \App\Seller_payments::find($id)
        ]);
    }

    public function set_paid_amount($id)
    {
        \App\Seller_payments::where('id',$id)->update(['payment_status' => 'Paid']);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Seller_payments(),
            'property' => \App\Seller_payments::find($id),
            'type' => 'Update',
            'log' => 'Change Payment Status "Paid" Payment. Changed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success', \App\Seller_payments::find($id)->partner->user->name." Payment has been paid.");
    }

    public function set_pending_amount($id)
    {
        \App\Seller_payments::where('id',$id)->update(['payment_status' => 'Pending']);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Seller_payments(),
            'property' => \App\Seller_payments::find($id),
            'type' => 'Update',
            'log' => 'Change Payment Status "Pending" Payment. Changed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success', \App\Seller_payments::find($id)->partner->user->name." Payment has been set as Pending.");
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
        //
    }
}
