<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class ServicePaymentController extends Controller
{
    public function __construct()
    {
        \App\Payments::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Products(),
            'property' => ['name' => 'Check Service Sale List'],
            'type' => 'Read',
            'log' => 'Check Check Service Sale List Read By ' . \Auth::user()->name,
        ]));

        return view('backend.payments.services.index');
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
        //
    }
}
