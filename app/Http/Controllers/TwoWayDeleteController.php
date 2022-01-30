<?php

namespace App\Http\Controllers;

use App\Delete_verification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TwoWayDeleteController extends Controller
{

    public function destroy_all_record(Request $request){
        $this->send_verification_code($request->type);
        return redirect()->route('show.verification.page',$request->type);
    }

    public function show_two_factor_view($type){
        return view('backend.delete_verification.index',['data_type'=>$type]);
    }

    function send_verification_code($type){
        $v_code = Str::random(6);
        $data_delete = array(
            'type' => $type,
            'two_factor_code' => $v_code,
            'user_id' => \Auth::guard('admin')->user()->id,
            'name' => \Auth::guard('admin')->user()->name,
            'user_mail' => \Auth::guard('admin')->user()->email,
            'two_factor_expires_at' => now()->addMinutes(15),
        );
        if(\App\Delete_verification::where('user_id',\Auth::guard('admin')->user()->id)->get()){
            \App\Delete_verification::where('user_id',\Auth::guard('admin')->user()->id)->delete();
        }
        \App\Delete_verification::create($data_delete);

        \Mail::send('backend.emails.delete_verification', ['data'=>$data_delete], function($message) use ($data_delete){
            $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
            $message->to($data_delete["user_mail"]);
            $message->subject(\config('app.name').' Delete Records Verification');
        });
    }

    public function resend_verification_code($type){
        $this->send_verification_code($type);
        return redirect()->back()->withMessage('The verification code has been sent again');
    }

    public function verify_code(Request $request){
        $request->validate([
            'two_factor_code' => 'required',
            'type' => 'required'
        ]);

        $user = \App\Delete_verification::where('user_id',\auth::guard('admin')->user()->id)->first();
        if(\Auth::guard('admin')->check() && $user) {
            if ($user->two_factor_expires_at->lt(now())) {
                return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code has expired. Please resend code again.']);
            }else{
                if($request->input('two_factor_code') == $user->two_factor_code)
                {
                    $user->delete();
                    if($request->input('type') == "users"){
                        \App\User::whereIn('id',\App\User::WhereNull('is_deleted')->pluck('id')->toarray())->delete();
                        return redirect()->route('users.index')->with('success','All users record has been cleared.');
                    }elseif($request->input('type') == "orders"){
                        \App\Orders::whereIn('id',\App\Orders::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('orders.index')->with('success','All orders record has been cleared.');
                    }
                    elseif($request->input('type') == "questions"){
                        \App\Questions::whereIn('id',\App\Questions::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('questions.index')->with('success','All questions record has been cleared.');
                    }
                    elseif($request->input('type') == "product-categories"){
                        \App\Product_category::whereIn('id',\App\Product_category::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('product-category.index')->with('success','All product categories record has been cleared.');
                    }
                    elseif($request->input('type') == "products"){
                        \App\Products::whereIn('id',\App\Products::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('products.index')->with('success','All products record has been cleared.');
                    }
                    elseif($request->input('type') == "vouchers"){
                        \App\Vouchers::whereIn('id',\App\Vouchers::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('vouchers.index')->with('success','All vouchers record has been cleared.');
                    }
                    elseif($request->input('type') == "voucher-customers"){
                        \App\Voucher_customers::whereIn('id',\App\Voucher_customers::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('voucher-customers.index')->with('success','All voucher customers record has been cleared.');
                    }
                    elseif($request->input('type') == "service-categories"){
                        \App\Service_category::whereIn('id',\App\Service_category::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('service-category.index')->with('success','All service category record has been cleared.');
                    }
                    elseif($request->input('type') == "services"){
                        \App\Service::whereIn('id',\App\Service::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('services.index')->with('success','All services record has been cleared.');
                    }
                    elseif($request->input('type') == "reservations"){
                        \App\Service_booking::whereIn('id',\App\Service_booking::WhereNull('is_deleted')->pluck('id')->toarray())->update(['is_deleted' => \Carbon\Carbon::now()]);
                        return redirect()->route('reservations.index')->with('success','All reservations record has been cleared.');
                    }
                }else{
                    return redirect()->back()->withErrors(['two_factor_code' => 'The verification code you have entered does not match.']);
                }
            }
        }else{
            return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code has expired. Please resend code again.']);
        }
    }
}
