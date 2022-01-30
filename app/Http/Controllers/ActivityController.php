<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class ActivityController extends Controller
{

    public function __construct()
    {
        \App\ActivityLog::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\ActivityLog(),
            'property' => ['name' => 'Check Activity Log List'],
            'type' => 'Read',
            'log' => 'Check Activity Log List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.activity_log.index');
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
            'model' => new \App\ActivityLog(),
            'property' => \App\ActivityLog::find($id),
            'type' => 'Read',
            'log' => 'Check Activity Log Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.activity_log.view')->with(
            ['data' => \App\ActivityLog::find($id)]
        );
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
