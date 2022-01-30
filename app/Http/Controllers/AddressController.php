<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AddressController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'address' =>  ['required',
                Rule::unique('user_addresses')
                    ->where('address', $request->address)
                    ->where('user_id',\auth::user()->id)
                    ->whereNull('is_deleted')
            ],
        ]);

        if(\App\User_address::where('user_id',\auth::user()->id)->wherenull('is_deleted')->get()->count() < 2){
            $table=\App\User_address::create($request->all());
            return back()->with('success',"Your address has been added.");
        }else{
            return back()->with('error',"Sorry, You can't add more than two address.");
        }
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
        \App\User_address::where('id',$id)->update(['is_deleted' => \Carbon\Carbon::now()]);
        return back()->with('success',"Your address has been deleted.");
    }
}
