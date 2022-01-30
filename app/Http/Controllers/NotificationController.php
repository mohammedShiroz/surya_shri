<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;

class NotificationController extends Controller
{

    public function index()
    {
        foreach (\App\Notifications::get() as $item) {
            \App\Notifications::where('id',$item->id)->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }
        return view('backend.notifications.index');
    }


    public function notification_types($type){

        if($type == "login"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewLogin')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Admin Login' ]);
        }elseif($type == "web_visitor"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewVisit')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Web Visit' ]);
        }elseif($type == "new_user"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewUser')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'New User' ]);
        }elseif($type == "question_completed"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\QuestionCompleted')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Questionnaire Completion' ]);
        }elseif($type == "orders"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewOrder')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Order Purchase' ]);
        }elseif($type == "booking"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewBooking')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Service Reservation' ]);
        }elseif($type == "withdrawal_request"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewWithdrawal')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Withdrawal Request' ]);
        }elseif($type == "voucher_usage"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewVoucher')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Voucher Usage' ]);
        }elseif($type == "fund_transfer"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewFund')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Fund Transfer' ]);
        }elseif($type == "donation"){
            return view('backend.notifications.category',[ 'notifications' => \App\Notifications::where('type','App\Notifications\NewDonation')->whereNull('read_at')->orderby('created_at','DESC')->get(), 'type' => 'Donation' ]);
        }
    }

    public function update_notifications($type){

        if($type == "Admin Login"){
            \App\Notifications::where('type','App\Notifications\NewLogin')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "Web Visit"){
            \App\Notifications::where('type','App\Notifications\NewVisit')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "New User"){
            \App\Notifications::where('type','App\Notifications\NewUser')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "Questionnaire Completion"){
            \App\Notifications::where('type','App\Notifications\QuestionCompleted')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "Order Purchase"){
            \App\Notifications::where('type','App\Notifications\NewOrder')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "Service Reservation"){
            \App\Notifications::where('type','App\Notifications\NewBooking')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "Withdrawal Request"){
            \App\Notifications::where('type','App\Notifications\NewWithdrawal')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "Voucher Usage"){
            \App\Notifications::where('type','App\Notifications\NewVoucher')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "Fund Transfer"){
            \App\Notifications::where('type','App\Notifications\NewFund')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }elseif($type == "Donation"){
            \App\Notifications::where('type','App\Notifications\NewDonation')->update([
                'read_at' => \Carbon\Carbon::now(),
                'read_by' => \auth::user()->id
            ]);
        }

        return response()->json([
            'data' => view('backend.components.notifications.index')->render(),
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
