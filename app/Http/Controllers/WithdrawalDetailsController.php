<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class WithdrawalDetailsController extends Controller
{
    public function __construct()
    {
        \App\WithdrawalDetails::observe(ActivityLogObserver::class);
    }

    public function index()
    {
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        if(\auth::user()->haspermission('update-Withdrawal-Details')) {
            $message = [
                'fee_amount.required' => 'Required withdrawal Fee Amount or Percentage'
            ];
            if(!$request->input('fee_amount') && !$request->input('percentage')){
                $this->validate($request, [
                    'fee_amount' => 'required',
                ], $message);
            }

            \App\WithdrawalDetails::where('id', $id)->update($request->except(['_token', '_method']));
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\WithdrawalDetails(),
                'property' => \App\WithdrawalDetails::find($id),
                'type' => 'Update',
                'log' => 'Update '.$request->input('type').' Wallet Withdrawal Details. Updated By ' . \auth::user()->name,
            ]));
            return redirect()->back()->with('success', $request->input('type') . ' Wallet Withdrawal Details has been updated.');
        }
        abort(403);
    }

    public function update_auto_withdrawal_time(Request $request){
        $this->validate($request,[
            'time' => 'required',
        ]);
        \App\Details::where('key','auto_withdrawal_time')->update([ 'value' => $request->input('time') ]);
        return redirect()->back()->with('success','Automatic total wallet point transfer time period has been changed.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
