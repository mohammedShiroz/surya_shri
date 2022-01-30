<?php

namespace App\Http\Controllers;

use App\Partner_vouchers;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpController extends Controller
{
    public function index()
    {
        return view('employee_dashboard.home');
    }

    public function send_employee_request(Request $request){
        $this->validate($request,[
            'referral' => 'required'
        ]);
        \App\Agent::create([
            'user_id' => \auth::user()->id,
            'ref_id' => $request->input('referral'),
            'intro_id' => $request->input('referral'),
            'placement_id' => $request->input('referral'),
        ]);

        \App\User::where('id',\auth::user()->id)->update([
            'request_referral' => $request->referral,
            'agent_request_date' => Carbon::now(),
            'agent_status' => 'Approved',
            'agent_id' => \App\Agent::where('user_id',\auth::user()->id)->first()->id
        ]);

        if($request->friends_invite_check){
            //:record invited friends count
            \App\Emp_friends_invite::create([
                'agent_id' => $request->referral,
                'user_id' => \Auth::user()->id,
            ]);
        }
        return redirect()->back()->with('success','Congratulations '.\auth::user()->name."! Your partnership request approved.");
    }

    public function profile(){

        return view('employee_dashboard.profile');
    }

    public function hierarchy_view(){

        return view('employee_dashboard.hierarchy_view');
    }

    public function partner_commission($id){
        return view('employee_dashboard.view_partner_commission',['data'=>\App\User::find(HashDecode($id))]);
    }

    public function products(){

        return view('employee_dashboard.products');
    }

    public function services(){

        return view('employee_dashboard.services');
    }

    public function vouchers(){

        return view('employee_dashboard.vouchers');
    }

    function generate_coupon_code($length = 20) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function generate_voucher_code(Request $request){

        if($request->ajax()){

            if(\App\Vouchers::where('code',$request->code)->wherenull('is_deleted')->First()){
                $data=\App\Vouchers::where('code',$request->code)->First();
                if($data->status == "Disabled"){
                    return response()->json([
                        'error' => ['title' => 'Voucher Blocked', 'text' => 'You\'ve entered voucher code is now currently disabled.']
                    ]);
                }
                if(\Carbon\Carbon::now()->subDays(1)->between(new \DateTime(), new \DateTime($data->expiry_date)) && !empty($data->expiry_date)){
                    return response()->json([
                        'error' => ['title' => 'Voucher Code Expired', 'text' => 'You\'ve entered voucher code is expired...']
                    ]);
                }

                if($data->customers->count() >= $data->allowed_users && !empty($data->allowed_users)) {
                    return response()->json([
                        'error' => ['title' => 'Customers limited', 'text' => 'Sorry, The voucher code has crossed allowed customers limits...']
                    ]);
                }

                if($data->allow_type == "single" && \app\Voucher_customers::where('user_id',\auth::user()->id)->where('voucher_id',$data->id)->first()){
                    return response()->json([
                        'error' => ['title' => 'Voucher Code Used', 'text' => 'You\'ve already used this voucher code ...']
                    ]);
                }
                $voucher_get_code = $this->generate_coupon_code(12);
                if(!\App\Partner_vouchers::where('g_code',$voucher_get_code)->first()){ $voucher_code = $voucher_get_code;
                }else{ $voucher_code = rand(0,10)+$voucher_get_code;}

                return response()->json([
                    'success' => ['title' => 'Success', 'text' => 'Your voucher code has been generated successfully. Please submit to publish your code.','voucher' => $data,'code' =>$voucher_code ]
                ]);

            }else{
                return response()->json([
                    'error' => ['title' => 'Invalid Code', 'text' => 'You\'ve entered invalid code. Please apply valid code.']
                ]);
            }
        }
        return redirect()->back()->with('error','Invalid voucher code applied. try again later.');
    }

    public function create_redeem_vouchers(Request $request){

        $this->validate($request,[
            'voucher_code' => 'required',
        ]);

        $voucher = \App\Vouchers::where('code',$request->voucher_code)->WhereNull('is_deleted')->first();

        if($voucher){
            $data=$voucher;
            if($data->status == "Disabled"){
                return redirect()->back()->with('error',"You've entered voucher code is now currently disabled.");
            }

            if(\Carbon\Carbon::now()->subDays(1)->between(new \DateTime(), new \DateTime($data->expiry_date)) && !empty($data->expiry_date)){
                return redirect()->back()->with('error',"You've entered voucher code is expired...");
            }

            if($data->customers->count() >= $data->allowed_users && !empty($data->allowed_users)) {
                return redirect()->back()->with('error',"The voucher code has crossed allowed customers limits...");
            }

            if($data->allow_type == "single" && \app\Voucher_customers::where('user_id',\auth::user()->id)->where('voucher_id',$data->id)->first()){
                return redirect()->back()->with('error',"You've already used this voucher code ...");
            }

            if($data->discount_type != "price") {
                return redirect()->back()->with('error',"You've entered invalid voucher code.");
            }

            $table=\App\RedeemPoints::create([
                'user_id' => \auth::user()->id,
                'voucher_id' => $voucher->id,
                'points' => ($voucher->discount*\App\Details::where('key','points_rate')->first()->amount),
            ]);

            \App\Voucher_customers::create([
                'voucher_id' => $voucher->id,
                'user_id' => \auth::user()->id,
                'redeem_id' => $table->id
            ]);
            return redirect()->back()->with('success',"Congratulations. You are now entitled to get ".getPointsFormat(($voucher->discount*\App\Details::where('key','points_rate')->first()->amount))." points.");

        }else{
            return redirect()->back()->with('error',"You've entered invalid voucher code. please apply valid voucher code.");
        }

    }

    public function destroy_vouchers(Request $request){
        $voucher_code = \App\Partner_vouchers::find($request->input('code_id'));
        \App\Partner_vouchers::where('id',$request->input('code_id'))->update(['is_deleted' => \Carbon\Carbon::now()]);
        return redirect()->back()->with('success', 'Your '.$voucher_code->g_code.' voucher code has been removed.');
    }

    public function summary(){

        return view('employee_dashboard.summary');
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
