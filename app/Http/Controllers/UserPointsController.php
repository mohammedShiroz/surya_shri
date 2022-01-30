<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class UserPointsController extends Controller
{
    public function __construct()
    {
        \App\Points::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Points(),
            'property' => ['name' => 'Check User Wallet List'],
            'type' => 'Read',
            'log' => 'Check User Wallet List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.wallet.points.index');
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
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\User(),
            'property' => \App\User::find($id),
            'type' => 'Read',
            'log' => 'Check User Wallet Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.wallet.show',['data'=>\App\User::find($id)]);
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
