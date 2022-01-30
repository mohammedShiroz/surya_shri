<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class DoctorController extends Controller
{
    public function __construct()
    {
        \App\Agent::observe(ActivityLogObserver::class);
    }
    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Agent(),
            'property' => ['name' => 'Check Doctors List'],
            'type' => 'Read',
            'log' => 'Check Doctors List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.doctors.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'partner_id' => 'required'
        ]);
        if(\auth::user()->haspermission(['create-doctors','update-doctors'])) {

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Agent(),
                'property' => \App\Agent::find($request->input('partner_id')),
                'type' => 'Create',
                'log' => 'Appointed a doctor Appointed By ' . \Auth::user()->name,
            ]));

            \App\Agent::where('id', $request->input('partner_id'))->update([
                'is_doctor' => \Carbon\Carbon::now()
            ]);
            return redirect()->back()->with('success', \App\Agent::where('id', $request->input('partner_id'))->first()->user->name . " - is now appointed as doctor.");
        }
        abort(403);
    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Agent(),
            'property' => \App\User::find($id),
            'type' => 'Read',
            'log' => 'Check Doctor Details Read By ' . \Auth::user()->name,
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
        //
    }
}
