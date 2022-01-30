<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Observers\ActivityLogObserver;

class UsersController extends Controller
{

    public function __construct()
    {
        \App\User::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\User(),
            'property' => ['name' => 'Check Buyer List'],
            'type' => 'Read',
            'log' => 'Buyer List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.index');
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
            'log' => 'Check Buyer Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.customers.show',[
            'data' => \App\User::find($id),
        ]);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $table = \App\User::where('id',$id)->first();
        $table->delete();
//        \App\User::where('id',$id)->update([ 'is_deleted' => Carbon::now()]);
        return redirect()->back()->with('success', $table->name." ".$table->last_name." - User has been removed.");
    }

    public  function destroy_all(){
        foreach(\App\User::all() as $row){
//            \App\User::where('id',$row->id)->update(['is_deleted' => Carbon::now()]);
            \App\User::where('id',$row->id)->delete();
        }
        return redirect()->back()->with('success', "All admin_users records removed.");
    }


    public function add_notes(Request $request){
        $this->validate($request,[
            'additional' => 'required'
        ]);
        $table = \App\sellers_additional_notes::create($request->all());
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\sellers_additional_notes(),
            'property' => \App\sellers_additional_notes::find($table->id),
            'type' => 'Create',
            'log' => 'Create Seller/Doctor Note Created By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',"Seller/Doctor additional note has been added");
    }

    public function delete_notes($id){
        \App\sellers_additional_notes::where('id',$id)->update(['is_deleted'=> \Carbon\Carbon::now()]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\sellers_additional_notes(),
            'property' => \App\sellers_additional_notes::find($id),
            'type' => 'Delete',
            'log' => 'Delete Seller/Doctor Note Delete By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',"Seller/Doctor additional note has been deleted");
    }
}
