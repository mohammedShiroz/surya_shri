<?php

namespace App\Http\Controllers;

use App\Notifications\NewDonation;
use App\Notifications\NewFund;
use App\Notifications\NewWithdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Observers\ActivityLogObserver;
use Image;
use League\Flysystem\Config;

class WalletController extends Controller
{
    public function index(){
        return view('user_wallet.index');
    }

    public function points(){
        return view('user_wallet.points');
    }

    public function update_transfer_point(Request $request){

        if($request->input('transfer_type') == "users"){
            $this->validate($request, [
                'receiver_name' => 'required',
                'points' => 'required'
            ]);

            if(1 >= $request->input('points')){
                return redirect()->back()->with('error','This '.$request->input('points').' points not eligible to transfer.');
            }

            if(getTransferablePoints(\auth::user()->id) < 0){
                return redirect()->back()->with('error','This '.$request->input('points').' points not eligible to transfer.');
            }

            if(getTransferablePoints(\auth::user()->id) < $request->input('points')){
                return redirect()->back()->with('error','This '.$request->input('points').' points not eligible to transfer.');
            }

            if(\auth::user()->id != $request->input('receiver_name')){
                $table = \App\Points::create([
                    'user_id' => \Auth::user()->id,
                    'forward_points' => $request->input('points'),
                    'forward_user_id' => $request->input('receiver_name'),
                    'week' => Carbon::now()->weekOfYear,
                ]);
                \App\Points::find($table->id)->notify(new NewFund($table));
                return redirect()->back()->with('success','Your '.$request->input('points').' points has been transfer to '.\App\User::where('id',$request->input('receiver_name'))->first()->name.' '.\App\User::where('id',$request->input('receiver_name'))->first()->last_name);
            }else{
                return redirect()->back()->with('error','This '.$request->input('points').' points, can\'t able to transfer your account.');
            }

        }elseif($request->input('transfer_type') == "donation"){

            $this->validate($request, [
                'receiver_name' => 'required',
                'donation_points' => 'required'
            ]);

            if((getFinalPoints()["available_points"]) < 0){
                return redirect()->back()->with('error','This '.$request->input('donation_points').' points not eligible to transfer.');
            }

            if((getFinalPoints()["available_points"]) < $request->input('donation_points')){
                return redirect()->back()->with('error','This '.$request->input('points').' points not eligible to transfer.');
            }

            $table = \App\Points::create([
                'user_id' => \Auth::user()->id,
                'forward_points' => $request->input('donation_points'),
                'forward_user_id' => $request->input('receiver_name'),
                'week' => Carbon::now()->weekOfYear,
            ]);

            $table_commission = \App\Points_Commission::create([
                'user_id' => \App\User::Where('prefix','Donations')->first()->id,
                'agent_id' => (\auth::user()->employee)? \auth::user()->employee->id :  null,
                'feature_partner_user_id' => (\auth::user()->employee)? null :  \auth::user()->id,
                'type' => 'Donations',
                'commission_points' => $request->input('donation_points'),
                'amount' => null,
                'week' => \Carbon\Carbon::now()->format('W'),
                'pay_type' => "User Transfer Donation"
            ]);
            \App\Points_Commission::find($table_commission->id)->notify(new NewDonation($table_commission));
            return redirect()->back()->with('success','Your '.$request->input('donation_points').' points has been donated to '.env('APP_NAME'));

        }

    }

    public function transfer_points(){
        return view('user_wallet.transfer_points');
    }

    public function fetch_user(Request $request){
        if($request->ajax()) {
            $response = array();
            $term_text = trim($request->search_term);
            $numberofrecords = 50;
            if (empty($term_text)) {
                echo json_encode([]);
            }
            else{
                $search_terms = explode(' ', $term_text);
                $table = \App\User::where(function ($query) use ($search_terms) {
                    foreach ($search_terms as $term) {
                        $query->orwhere('name', 'LIKE', '%' . $term . '%');
                    }
                    foreach ($search_terms as $term) {
                        $query->orwhere('email', 'LIKE', '%' . $term . '%');
                    }

                })->where('id','!=',\Auth::user()->id)->orderby('name', 'asc')->paginate($numberofrecords);
                if(count($table)>0){
                    foreach($table as $row){
                        $response[] = array(
                            "id" => $row->id,
                            "text" => $row->name." - ".$row->email,
                        );
                    }
                    echo json_encode($response);
                }else{
                    echo json_encode([]);
                }
            }
        }
    }

    public function credited_points(){
        return view('user_wallet.credited_points');
    }

    public function used_points(){
        return view('user_wallet.used_points');
    }

    public function refund_points(){
        return view('user_wallet.refund_points');
    }

    public function withdrawal_points(){
        return view('user_wallet.withdrawal_points');
    }

    public function history(){
        return view('user_wallet.history');
    }
    public function seller_points(){
        return view('user_wallet.seller_points');
    }

    public function update_withdrawal_point(Request $request){

        $this->validate($request, [
            'points' => 'required'
        ]);

        if(!\auth::user()->bank_details){
            return redirect()->back()->with('error','Before request please update your bank details first.');
        }

        if((getWithdrawalablePointsByUser(\auth::user()->id)["total_Withdrawalable_points"]) < 0){
            return redirect()->back()->with('error','This '.$request->input('points').' points not eligible to withdrawal.');
        }

        if((getWithdrawalablePointsByUser(\auth::user()->id)["total_Withdrawalable_points"]) < $request->input('points')){
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
            'user_id' => \Auth::user()->id,
            'withdrawal_points' => $request->input('points'),
            'fee_amount' => $paid_fees_amount,
            'week' => Carbon::now()->weekOfYear,
        ]);
        \App\Withdrawal_points::find($table->id)->notify(new NewWithdrawal($table));

        //:: update withdrawal fee amount to site wallet
        \App\Points_Commission::create([
            'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
            'type' => 'Site',
            'commission_user_id' => \auth::user()->id,
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
        return redirect()->back()->with('success',$request->input('points').' withdrawal points request has been send.');
    }

    public function update_withdrawal_bank_details(Request $request){

        if(!\auth::user()->bank_details){
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

            return redirect()->back()->with('success','Your bank details has been saved.');

        }

    }
}
