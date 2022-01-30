<?php

namespace App\Http\Controllers;

use App\Notifications\NewOrder;
use App\Notifications\NewVoucher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('cart.checkout');
    }

    public function check_voucher_valid(Request $request){

        if($request->ajax()){
            $voucher = null;
            if($request->input('is_partner') == 'yes'){
                $partner_voucher = \App\Partner_vouchers::where('g_code',$request->code)->WhereNull('is_deleted')->first();
                if($partner_voucher){
                    if($partner_voucher->status == "Disabled"){
                        return response()->json([
                            'error' => ['title' => 'Voucher Blocked', 'text' => 'You\'ve entered voucher code is now currently disabled.']
                        ]);
                    }
                    $voucher = \App\Vouchers::where('code',$partner_voucher->admin_voucher->code)->WhereNull('is_deleted')->first();
                    $voucher_owner_name = $partner_voucher->partner->user->name;
                    $voucher_owner_id = $partner_voucher->partner->id;
                }else{
                    return response()->json([
                        'error' => ['title' => 'Invalid Code', 'text' => 'You\'ve entered invalid code. Please apply valid code.']
                    ]);
                }

            }else{
                $voucher_owner_name = env('APP_NAME');
                $voucher_owner_id = 0;
                $voucher = \App\Vouchers::where('code',$request->code)->WhereNull('is_deleted')->first();
            }

            if($voucher){
                $data=$voucher;
                if($data->status == "Disabled"){
                    return response()->json([
                        'error' => ['title' => 'Voucher Blocked', 'text' => 'You\'ve entered voucher code is now currently disabled.']
                    ]);
                }

                if($data->voucher_type == "Reservation"){
                    return response()->json([
                        'error' => ['title' => 'Invalid Voucher', 'text' => 'You\'ve entered invalid voucher code. You can use this voucher for service reservation ...']
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

                if($request->total < $data->minimum_total && !empty($data->minimum_total)) {
                    return response()->json([
                        'error' => ['title' => 'Minimum Total Limited', 'text' => 'Required minimum total '.getCurrencyFormat($data->minimum_total).'. You currently not allowed to apply due to not enough shopping total...']
                    ]);
                }

                return response()->json([
                    'success' => ['title' => 'CONGRATULATIONS', 'text' => "You are now entitled to a lifetime discount of up to ".(($data->discount_type =="percentage")? $data->discount.'%' : getCurrencyFormat($data->discount))." on all service reservations and product purchases.",'voucher' => $data, 'voucher_owner_name' => $voucher_owner_name, 'voucher_owner_id' => $voucher_owner_id]
                ]);

            }else{

                if(\App\UserCouponCode::where('code',$request->code)->first()){
                    if(\auth::user()->employee){
                        return response()->json([
                            'error' => ['title' => 'Code Activated', 'text' => 'Your lifetime coupon code is activated!']
                        ]);
                    }else{
                        return response()->json([
                            'success_coupon_code' => [
                                'title' => 'CONGRATULATIONS',
                                'text' => "As a Partner, you are now entitled to a lifetime discount of up to 20% on all service reservations and product purchases.",
                                'voucher_owner' => \App\User::find(\App\UserCouponCode::where('code',$request->code)->first()->user_id),
                                'voucher_owner_id' => \App\User::find(\App\UserCouponCode::where('code',$request->code)->first()->user_id)->employee->id,
                                'coupon_id' => \App\UserCouponCode::where('code',$request->code)->first()->id,
                                'user_code' => null,
                                'voucher_name' => 'Coupon Code Activated',
                                'voucher_owner_name' => \App\User::find(\App\UserCouponCode::where('code',$request->code)->first()->user_id)->name." ".\App\User::find(\App\UserCouponCode::where('code',$request->code)->first()->user_id)->last_name,
                                'order_items' => view('cart.item_reviews.order_items',['discount_activate' => 'activated'])->render(),
                                'order_amount' => view('cart.item_reviews.item_total',['discount_activate' => 'activated'])->render(),
                                'order_online_amount' => view('cart.item_reviews.online_payment',['discount_activate' => 'activated'])->render(),
                            ]
                        ]);
                    }

                }elseif(\App\User::where('user_code',$request->code)->first()){
                    if(\auth::user()->employee){
                        return response()->json([
                            'error' => ['title' => 'Code Activated', 'text' => 'Your lifetime coupon code is activated!']
                        ]);
                    }else{
                        return response()->json([
                            'success_coupon_code' => [
                                'title' => 'CONGRATULATIONS',
                                'text' => "You are now entitled to a lifetime discount of up to 20% on all service reservations and product purchases.",
                                'voucher_owner' => \App\User::where('user_code',$request->code)->first(),
                                'voucher_owner_id' => \App\User::where('user_code',$request->code)->first()->employee->id,
                                'coupon_id' => null,
                                'user_code' => $request->code,
                                'voucher_name' => 'Coupon Code Activated',
                                'voucher_owner_name' => \App\User::where('user_code',$request->code)->first()->name." ".\App\User::where('user_code',$request->code)->first()->last_name,
                                'order_items' => view('cart.item_reviews.order_items',['discount_activate' => 'activated'])->render(),
                                'order_amount' => view('cart.item_reviews.item_total',['discount_activate' => 'activated'])->render(),
                                'order_online_amount' => view('cart.item_reviews.online_payment',['discount_activate' => 'activated'])->render(),
                            ]
                        ]);
                    }
                }else{
                    return response()->json([
                        'error' => ['title' => 'Invalid Code', 'text' => 'You\'ve entered invalid code. Please apply valid code.']
                    ]);
                }
            }
        }
        return redirect()->back()->with('error','Invalid voucher code applied. try again later.');
    }

    public function remove_voucher_code(Request $request){
        return response()->json([
            'order_items' => view('cart.item_reviews.order_items',['discount_activate' => null])->render(),
            'order_amount' => view('cart.item_reviews.item_total',['discount_activate' => null])->render(),
            'order_online_amount' => view('cart.item_reviews.online_payment',['discount_activate' => null])->render(),
        ]);
    }

    public function points_payments(Request $request){

        $this->validate($request, [
            'track_id'=>'required',
            'user_id' => 'required'
        ]);

        $success_msg='success';
        //:store order details
        $table = \App\Orders::create($request->all());
        $table->payment_status = "Success";
        $table->save();
        $order_id = \App\Orders::orderby('created_at','desc')->first()->id;
        //: store order items
        $sub_total=0;
        foreach (\Cart::instance('shopping')->content() as $item){
           if(\auth::user()->employee){ if($item->options->agent_pay_amount){ $sub_total = ($item->options->agent_pay_amount*$item->qty); }else{ $sub_total = $item->subtotal;}
           }else{ $sub_total = $item->subtotal; }
           \App\Order_items::create([
               'order_id' => $order_id,
               'product_id' => $item->id,
               'qty' => $item->qty,
               'sub_total' =>$sub_total,
           ]);
           //:reduce the stock from store
           $table_product=\App\Products::where('id',$item->id)->first();
           $table_product->update([ 'stock' => ($table_product->stock - $item->qty) ]);
        }
        //:store order customer details
        \App\Order_Customer_data::create([
            'order_id' => $order_id,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'country' => $request->input('country'),
            'city' => $request->input('city'),
            'contact' => $request->input('contact'),
            'email' => $request->input('email'),
            'note' => $request->input('note'),
        ]);

        //:store booking payment details
        $table_payment=\App\Payments::create($request->all());
        $table_payment->type = "product";
        $table_payment->order_id = $order_id;
        $table_payment->payment_status = "success";
        $table_payment->save();

        if($request->input('voucher_id')){
            $table_voucher=\App\Voucher_customers::create($request->all());
            $table_voucher->user_id = $request->input('user_id');
            $table_voucher->order_id = $order_id;
            $table_voucher->save();
            \App\Voucher_customers::find($table_voucher->id)->notify(new NewVoucher($table_voucher));
        }

        if($request->input('voucher_ref_by')){
            if(!\auth::user()->employee){
                \App\Agent::create([
                    'user_id' => \auth::user()->id,
                    'ref_id' => $request->input('voucher_ref_by'),
                    'intro_id' => $request->input('voucher_ref_by'),
                    'placement_id' => $request->input('voucher_ref_by'),
                ]);
                \App\User::where('id',\auth::user()->id)->update([
                    'agent_id' => \App\Agent::where('user_id',\auth::user()->id)->first()->id,
                    'request_referral' => $request->input('voucher_ref_by'),
                    'agent_status' => "Approved",
                    'agent_request_date' => \Carbon\Carbon::now(),
                    'is_partner_voucher_request' => \Carbon\Carbon::now(),
                    'is_invited' => $request->input('voucher_ref_by'),
                ]);

                \App\UsedUserCoupons::create([
                    'user_id' => \auth::user()->id,
                    'partner_id' => $request->input('voucher_ref_by'),
                    'coupon_id' => $request->input('coupon_id'),
                    'user_code' => $request->input('user_code'),
                    'order_id' => $table->id,
                    'booking_id' => null,
                ]);
                $success_msg = $request->input('voucher_ref_by');
            }
        }
        \Cart::destroy();

        $tableOrderInfo=\App\Orders::find($table->id);
        \App\Orders::find($table->id)->notify(new NewOrder($tableOrderInfo));

        $data = \App\Orders::find($table->id);
        \Mail::send('emails.order_notification', ['data'=>$data], function($message) use ($data){
            $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
            $message->to(\App\Details::where('key','company_email')->first()->value);
            $message->subject(\config('app.name').' Order Notification');
        });
        return redirect()->route('checkout.order.done')->with('order_success',$success_msg);
    }

    public function order_payment_success(Request $request){
        $merchant_id        = $request->input('merchant_id');
        $track_id           = $request->input('order_id');
        $payhere_amount     = $request->input('payhere_amount');
        $payhere_currency   = $request->input('payhere_currency');
        $status_code        = $request->input('status_code');
        $md5sig             = $request->input('md5sig');
        $merchant_secret    = '8bQZFzjOxAh8hf6XkaeaYL8QfoeMKXNgr4uXIRlaUHOX';
        $success_msg='success';
        $local_md5sig = strtoupper (md5 ( $merchant_id . $track_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret)) ) );
        if (($local_md5sig === $md5sig) AND ($status_code == 2) ){
            //TODO: Update your database as payment success
        }
        //TODO: Test Result
//        echo "1 ".$merchant_id."<br/>";
//        echo "2 ".$order_id."<br/>";
//        echo "3 ".$payhere_amount."<br/>";
//        echo "4 ".$payhere_currency."<br/>";
//        echo "5 ".$status_code."<br/>";
//        echo "6 ".$md5sig."<br/>";
//        echo "7 ".$merchant_secret."<br/>";
//        echo "<br/><br/>";
//        var_dump($request->all());
//        echo "<br/><br/>";
//        var_dump($local_md5sig);
        if(in_array($track_id, \App\Orders::pluck('track_id')->toArray())){

        }else {
            //:store order details
            $table = \App\Orders::create($request->all());
            $table->track_id = $track_id;
            $table->payment_status = "Success";
            $table->save();
            $order_id = \App\Orders::orderby('created_at', 'desc')->first()->id;
            //: store order items
            $sub_total = 0;
            foreach (\Cart::instance('shopping')->content() as $item) {
                if (\auth::user()->employee) {
                    if ($item->options->agent_pay_amount) {
                        $sub_total = ($item->options->agent_pay_amount * $item->qty);
                    } else {
                        $sub_total = $item->subtotal;
                    }
                } else {
                    $sub_total = $item->subtotal;
                }

                \App\Order_items::create([
                    'order_id' => $order_id,
                    'product_id' => $item->id,
                    'qty' => $item->qty,
                    'sub_total' => $sub_total,
                ]);
            }
            //:store order customer details
            \App\Order_Customer_data::create([
                'order_id' => $order_id,
                'name' => $request->input('customer_name'),
                'address' => $request->input('customer_address'),
                'country' => $request->input('customer_country'),
                'city' => $request->input('customer_city'),
                'contact' => $request->input('customer_contact'),
                'email' => $request->input('customer_email'),
                'note' => $request->input('customer_note'),
            ]);

            //:store booking payment details
            \App\Payments::create([
                'user_id' => $request->input('user_id'),
                'type' => "product",
                'order_id' => $order_id,
                'payment_method' => $request->input('payment_method'),
                'paid_amount' => $request->input('paid_amount'),
                'payment_status' => "success",
                'payment_signature' => $local_md5sig,
            ]);

            if ($request->input('voucher_id')) {
                $table_voucher = \App\Voucher_customers::create([
                    'voucher_id' => $request->input('voucher_id'),
                    'user_id' => $request->input('user_id'),
                    'order_id' => $order_id,
                ]);
                \App\Voucher_customers::find($table_voucher->id)->notify(new NewVoucher($table_voucher));
            }

            if($request->input('voucher_ref_by')){
                if(!\auth::user()->employee){
                    \App\Agent::create([
                        'user_id' => \auth::user()->id,
                        'ref_id' => $request->input('voucher_ref_by'),
                        'intro_id' => $request->input('voucher_ref_by'),
                        'placement_id' => $request->input('voucher_ref_by'),
                    ]);
                    \App\User::where('id',\auth::user()->id)->update([
                        'agent_id' => \App\Agent::where('user_id',\auth::user()->id)->first()->id,
                        'request_referral' => $request->input('voucher_ref_by'),
                        'agent_status' => "Approved",
                        'agent_request_date' => \Carbon\Carbon::now(),
                        'is_partner_voucher_request' => \Carbon\Carbon::now(),
                        'is_invited' => $request->input('voucher_ref_by'),
                    ]);

                    \App\UsedUserCoupons::create([
                        'user_id' => \auth::user()->id,
                        'partner_id' => $request->input('voucher_ref_by'),
                        'coupon_id' => $request->input('coupon_id'),
                        'user_code' => $request->input('user_code'),
                        'order_id' => $table->id,
                    ]);
                    $success_msg = $request->input('voucher_ref_by');
                }
            }

//            if ($request->input('voucher_provide_by') && $request->input('voucher_provide_by') != 0) {
//                if (!\auth::user()->employee) {
//                    \App\Agent::create([
//                        'user_id' => \auth::user()->id,
//                        'ref_id' => $request->input('voucher_provide_by'),
//                        'intro_id' => $request->input('voucher_provide_by'),
//                        'placement_id' => $request->input('voucher_provide_by'),
//                    ]);
//                    \App\User::where('id', \auth::user()->id)->update([
//                        'agent_id' => \App\Agent::where('user_id', \auth::user()->id)->first()->id,
//                        'request_referral' => $request->input('voucher_provide_by'),
//                        'agent_status' => "Approved",
//                        'agent_request_date' => \Carbon\Carbon::now(),
//                        'is_partner_voucher_request' => \Carbon\Carbon::now(),
//                        'is_invited' => $request->input('voucher_provide_by'),
//                    ]);
//                    \App\Emp_friends_invite::create([
//                        'agent_id' => $request->input('voucher_provide_by'),
//                        'user_id' => \auth::user()->id,
//                    ]);
//                    $success_msg = $request->input('voucher_provide_by');
//                }
//            }
            \Cart::destroy();
            $tableOrderInfo = \App\Orders::find($table->id);
            \App\Orders::find($table->id)->notify(new NewOrder($tableOrderInfo));
            $data = \App\Orders::find($table->id);
            \Mail::send('emails.order_notification', ['data'=>$data], function($message) use ($data){
                $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
                $message->to(\App\Details::where('key','company_email')->first()->value);
                $message->subject(\config('app.name').' Order Notification');
            });
        }
        return redirect()->route('checkout.order.done')->with('order_success',$success_msg);
    }

    public function order_payment_notify(Request $request){
        $merchant_id        = $request->input('merchant_id');
        $order_id           = $request->input('order_id');
        $payhere_amount     = $request->input('payhere_amount');
        $payhere_currency   = $request->input('payhere_currency');
        $status_code        = $request->input('status_code');
        $md5sig             = $request->input('md5sig');
        $merchant_secret    = '8bQZFzjOxAh8hf6XkaeaYL8QfoeMKXNgr4uXIRlaUHOX';
        $local_md5sig = strtoupper (md5 ( $merchant_id . order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret)) ) );
        \App\payment_notify::create($request->all());
        if (($local_md5sig === $md5sig) AND ($status_code == 2) ){
            \App\payment_notify::create($request->all());
        }
    }

    public function order_payment_failed(Request $request){

        return view('pages.products.orders.order_failed');
    }

    public function order_success(){

        if (\Session::has('order_success')){
            return view('pages.products.orders.order_success');
        }else{
            return redirect()->route('home');
        }
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
    }

    public function destroy($id)
    {
    }
}
