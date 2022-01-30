<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;
use Illuminate\Support\Carbon;
use Image;
use App\Notifications\NewWithdrawal;

class WithdrawalWalletController extends Controller
{
    public function __construct()
    {
        \App\Withdrawal_points::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.index');
    }

    public function users()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Users Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Users Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.users');
    }

    public function sellers()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Sellers Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Sellers Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.sellers');
    }

    public function doctors()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Doctors Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Doctors Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.doctors');
    }

    public function site()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Site Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Site Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.site',['data' => \App\User::where('prefix','Site')->first()]);
    }

    public function global()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Global Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Global Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.global',['data' => \App\User::where('prefix','Global')->first()]);
    }

    public function gift()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Bonus Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Bonus Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.gift',['data' => \App\User::where('prefix','Bonus')->first()]);
    }

    public function donations()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Donations Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Donations Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.donations',['data' => \App\User::where('prefix','Donations')->first()]);
    }


    public function requested_withdrawal(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Requested Withdrawal Points List'],
            'type' => 'Read',
            'log' => 'Check Requested Withdrawal Points List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.requested_withdrawal');
    }

    public function withdrawal_payments(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => ['name' => 'Check Withdrawal Payments List'],
            'type' => 'Read',
            'log' => 'Check Withdrawal Payments List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.withdrawal_payments');
    }


    public function withdrawal_points_details($type,$id){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\User(),
            'property' => \App\User::find($id),
            'type' => 'Read',
            'log' => 'Check Withdrawal Points Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.withdrawal_wallet.report_view',[
            'data' => \App\User::find($id),
            'width_type' => $type,
        ]);
    }

    public function send_withdrawal_request(Request $request){

        $this->validate($request, [
            'points' => 'required'
        ]);

        if((getWithdrawalablePointsByAdmin($request->input('user_id'))["total_Withdrawalable_points"]) < $request->input('points')){
            return redirect()->back()->with('error','This '.$request->input('points').' points not eligible to withdrawal.');
        }

        if(\App\WithdrawalDetails::where('type',$request->input('type'))->first()->minimum_limit >= $request->input('points')){
            return redirect()->back()->with('error','This '.$request->input('points').' points not eligible to Minimum Withdrawal.');
        }

        if(\App\WithdrawalDetails::where('type',$request->input('type'))->first()->maximum_limit < $request->input('points')){
            return redirect()->back()->with('error','This '.$request->input('points').' points not eligible to Maximum Withdrawal.');
        }

        //:: update withdrawal fee amount to site wallet
        $fee_amount = \App\WithdrawalDetails::where('type',$request->input('type'))->first()->fee_amount;
        $fee_percentage = \App\WithdrawalDetails::where('type',$request->input('type'))->first()->percentage;
        $paid_fees_amount = 0;
        if($fee_amount){
            $paid_fees_amount = \App\WithdrawalDetails::where('type',$request->input('type'))->first()->fee_amount;
        }elseif($fee_percentage){
            $paid_fees_amount =  (($fee_percentage / 100) * $request->input('points'));
        }

        $table=\App\Withdrawal_points::create([
            'user_id' => $request->input('user_id'),
            'withdrawal_points' => $request->input('points'),
            'fee_amount' => $paid_fees_amount,
            'week' => \Carbon\Carbon::now()->weekOfYear,
        ]);
        \App\Withdrawal_points::find($table->id)->notify(new NewWithdrawal($table));

        if(!\App\User::find($request->input('user_id'))->bank_details){
            $table=\App\WithdrawalUsersBankDetails::create($request->all());
            if ($request->hasFile('billing_proof')) {
                try {
                    $image = $request->file('billing_proof');
                    $input['billing_proof'] = "billing_proof_".rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/WithdrawalUsersBankDetails/thumbnail');
                    if (!file_exists($destinationPath)) { mkdir($destinationPath, 0777); }
                    $img1 = Image::make($image->path());
                    $img1->resize(540, 550);
                    $img1->save($destinationPath . '/' . $input['billing_proof']);
                    $destinationPath = public_path('/uploads/WithdrawalUsersBankDetails');
                    $image->move($destinationPath, $input['billing_proof']);
                    $destinationPath="uploads/WithdrawalUsersBankDetails/";
                    $table->billing_proof = $destinationPath.$input['billing_proof'];
                } catch (exception $e) { }
            }

            if ($request->hasFile('nic_proof')) {
                try {
                    $image = $request->file('nic_proof');
                    $input['nic_proof'] = "nic_proof_".rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('uploads/WithdrawalUsersBankDetails/thumbnail');
                    if (!file_exists($destinationPath)) { mkdir($destinationPath, 0777); }
                    $img1 = Image::make($image->path());
                    $img1->resize(540, 550);
                    $img1->save($destinationPath . '/' . $input['nic_proof']);
                    $destinationPath = public_path('/uploads/WithdrawalUsersBankDetails');
                    $image->move($destinationPath, $input['nic_proof']);
                    $destinationPath="uploads/WithdrawalUsersBankDetails/";
                    $table->nic_proof = $destinationPath.$input['nic_proof'];
                } catch (exception $e) { }
            }
            $table->save();
        }

        //:: update withdrawal fee amount to site wallet
        \App\Points_Commission::create([
            'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
            'type' => 'Site',
            'commission_user_id' => $request->input('user_id'),
            'commission_points' => ($paid_fees_amount * (\App\Details::where('key', 'points_rate')->first()->amount)),
            'amount' => $paid_fees_amount,
            'week' => \Carbon\Carbon::now()->format('W'),
            'pay_type' => "Withdrawal Charge"
        ]);
        \App\Points::create([
            'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
            'direct_points' => ($paid_fees_amount * (\App\Details::where('key', 'points_rate')->first()->amount)),
            'week' => \Carbon\Carbon::now()->format('W')
        ]);

        return redirect()->back()->with('success',$request->input('points').' '. $request->input('type').' wallet withdrawal request has been send.');
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
            'model' => new \App\Withdrawal_points(),
            'property' => \App\Withdrawal_points::find($id),
            'type' => 'Read',
            'log' => 'Check Withdrawal Points Details Read By ' . \Auth::user()->name,
        ]));

        return view('backend.withdrawal_wallet.view',[
            'data' => \App\Withdrawal_points::find($id),
        ]);
    }

    public function withdrawal_payments_details($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => \App\Withdrawal_points::find($id),
            'type' => 'Read',
            'log' => 'Check Withdrawal Payment Details Read By ' . \Auth::user()->name,
        ]));

        return view('backend.withdrawal_wallet.view_payment_details',[
            'data' => \App\Withdrawal_points::where('id',$id)->first(),
        ]);
    }
    public function confirm_request(Request $request){
        \App\Withdrawal_points::where('id',$request->input('point_id'))->update([ 'status' => 'Approved']);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => \App\Withdrawal_points::find($request->input('point_id')),
            'type' => 'Update',
            'log' => 'Confirmed Withdrawal Request. Confirmed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success','Request has been approved');
    }

    public function reject_request(Request $request){
        $this->validate($request, [
            'reject_description' => 'required'
        ]);

        \App\Withdrawal_points::where('id',$request->input('point_id'))->update([
            'status' => 'Rejected',
            'rejected_at' => \Carbon\Carbon::now(),
            'reject_description' => $request->input('reject_description')
        ]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Withdrawal_points(),
            'property' => \App\Withdrawal_points::find($request->input('point_id')),
            'type' => 'Update',
            'log' => 'Rejected Withdrawal Request. Rejected By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success','Request has been rejected');
    }

    public function confirm_payment(Request $request){

        if(\App\Withdrawal_points::where('id',$request->input('point_id'))->first()->status !="Provided") {


            $table=\App\Withdrawal_points::where('id', $request->input('point_id'))->update([
                'status' => 'Provided',
                'amount' => $request->input('paid_amount'),
                'transaction_id' => $request->input('point_id') . rand(10, 100) . date('ymdhis'),
                'given_date' => \Carbon\Carbon::now(),
            ]);

            if ($request->hasFile('pay_proof')) {
                try {
                    $image = $request->file('pay_proof');
                    $input['pay_proof'] = "pay_proof_".rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/WithdrawalPaymentDetails');
                    $image->move($destinationPath, $input['pay_proof']);
                    $destinationPath="uploads/WithdrawalPaymentDetails/";
                    \App\Withdrawal_points::where('id', $request->input('point_id'))->update([
                        'proofe_image' => $destinationPath.$input['pay_proof'],
                    ]);

                } catch (exception $e) { }
            }

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Withdrawal_points(),
                'property' => \App\Withdrawal_points::find($request->input('point_id')),
                'type' => 'Update',
                'log' => 'Confirmed Withdrawal Payment. Confirmed By ' . \Auth::user()->name,
            ]));

            return redirect()->back()->with('success', 'Points Payment was done.');
        }else{
            return redirect()->back()->with('success', 'Points Payment was already done.');
        }
    }

    public function approve_bank_info(Request $request){

        \App\WithdrawalUsersBankDetails::where('id',$request->input('detail_id'))->update(['status' => 'Approved']);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\WithdrawalUsersBankDetails(),
            'property' => \App\WithdrawalUsersBankDetails::find($request->input('detail_id')),
            'type' => 'Update',
            'log' => 'Approved User Bank Details. Approved By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success','Bank details has been approved.');
    }

    public function reject_bank_info(Request $request){
        \App\WithdrawalUsersBankDetails::where('id',$request->input('detail_id'))->update([
            'is_deleted' => \Carbon\Carbon::now(),
//            'reject_reason' => $request->input('reject_description')
        ]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\WithdrawalUsersBankDetails(),
            'property' => \App\WithdrawalUsersBankDetails::find($request->input('detail_id')),
            'type' => 'Update',
            'log' => 'Rejected User Bank Details. Rejected By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success','Bank details has been rejected.');
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
