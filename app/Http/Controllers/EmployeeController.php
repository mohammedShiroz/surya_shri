<?php

namespace App\Http\Controllers;

use App\Agent;
use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class EmployeeController extends Controller
{

    public function __construct()
    {
        \App\User::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Agent(),
            'property' => ['name' => 'Check Partners List'],
            'type' => 'Read',
            'log' => 'Partners List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.employee.index');
    }

    public function request_users(){

        return view('backend.customers.employee.request');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show_hierarchy(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\User(),
            'property' => ['name' => 'Show Hierarchy'],
            'type' => 'Read',
            'log' => 'Check Partner Hierarchy Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.employee.show_hierarchy');
    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\User(),
            'property' => \App\User::find($id),
            'type' => 'Read',
            'log' => 'Check Partner Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.show',[
            'data' => \App\User::where('id',$id)->firstOrFail(),
        ]);
    }

    public function show_request_users($id){

        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\User(),
            'property' => \App\User::find($id),
            'type' => 'Read',
            'log' => 'Check Partner Requested User Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.show',[
            'data' => \App\User::where('id',$id)->firstOrFail(),
        ]);
    }

    public function request_users_approve(Request $request){

        $this->validate($request,[
           'placement_id' => 'required'
        ]);
        \App\Agent::create($request->all());
        \App\User::where('id',$request->user_id)->update([
            'agent_status' => 'Approved',
            'agent_id' => \App\Agent::where('user_id',$request->user_id)->firstOrFail()->id,
        ]);
        return redirect()->route('employee.request')->with('success',  \App\User::where('id',$request->user_id)->firstOrFail()->name." - User's Employee request has been Approved.");
    }

    public function request_users_reject($id){
        \App\User::where('id',$id)->update([
           'agent_status' => 'Rejected',
        ]);
        return redirect()->route('employee.request')->with('success',  \App\User::where('id',$id)->firstOrFail()->name." - Employee request has been rejected.");
    }

    public function modifiy_agent_placement(Request $request){

        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Agent(),
            'property' => \App\Agent::find($request->agent_id),
            'type' => 'Update',
            'log' => 'Update Partner Placement Read By ' . \Auth::user()->name,
        ]));
        \App\Agent::where('id',$request->agent_id)->update(['placement_id'=> $request->placement_id]);
        return redirect()->back()->with('success',\App\Agent::where('id',$request->agent_id)->firstOrFail()->user->name.' - Placement has been updated.');
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
