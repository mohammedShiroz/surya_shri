<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class SiteWalletController extends Controller
{
    public function __construct()
    {
        \App\Points::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Points(),
            'property' => ['name' => 'Check Site Wallet List'],
            'type' => 'Read',
            'log' => 'Check Site Wallet List Read By ' . \Auth::user()->name,
        ]));

        return view('backend.wallet.site_wallet.index');
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
