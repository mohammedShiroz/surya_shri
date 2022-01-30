<?php

namespace App\Http\Controllers;

use App\Notifications\NewBooking;
use App\Notifications\NewVoucher;
use App\Service_booking;
use Illuminate\Http\Request;

class ServiceOperationController extends Controller
{
    public function store_service_review(Request $request)
    {
        $this->validate($request, [
            'rate' => 'required| max:5',
            'comments' => 'required',
            'name' => 'required',
        ]);
        $countOfBookings = \App\Service_booking::where('user_id',$request->input('user_id'))->where('service_id',$request->input('service_id'))->get()->count();
        $countOfReviews =\App\Service_review::where('user_id', $request->input('user_id'))->whereNull('is_deleted')->where('service_id', $request->input('service_id'))->get()->count();
        if($countOfBookings > $countOfReviews){
            \App\Service_review::create($request->all());
            return redirect()->back()->with('success', 'Thank you for your valuable review.');
        }else{
            return redirect()->back()->with('error', 'Looks like you already reviewed for all service reservation!');
        }
    }

    public function load_more_services_review(Request $request)
    {
        $data = \App\Service::find($request->service_id);
        $rows = $request->get('row_count');
        return view('components.services.service_review_data', [
            'service_reviews' => \App\Service_review::orderby('created_at', 'desc')->where('service_id', $request->service_id)->limit($rows)->get(),
            'get_rev_count' => $data->reviews->count(),
            'service_id' => $data->id,
        ])->render();
    }

    public function remove_service_review(Request $request)
    {
        \App\Service_review::where('user_id', $request->user_id)->where('service_id', $request->service_id)->delete();
        return redirect()->back()->with('success', \App\Service::where('id', $request->service_id)->firstOrFail()->name . '\'s service review has been cleared.');
    }

    public function services_reservations_booking($slug){
        return view('pages.services.reservation', [
            'data' => \App\Service::where('slug', $slug)->firstOrfail(),
        ]);
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
                if($data->voucher_type == "Shipping Amount" || $data->voucher_type == "Purchase"){
                    return response()->json([
                        'error' => ['title' => 'Invalid Voucher', 'text' => 'You\'ve entered invalid voucher code, You can use this voucher for purchase ...']
                    ]);
                }

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
                                'text' => "You are now entitled to a lifetime discount of up to 20% on all service reservations and product purchases.",
                                'voucher_owner' => \App\User::find(\App\UserCouponCode::where('code',$request->code)->first()->user_id),
                                'voucher_owner_id' => \App\User::find(\App\UserCouponCode::where('code',$request->code)->first()->user_id)->employee->id,
                                'coupon_id' => \App\UserCouponCode::where('code',$request->code)->first()->id,
                                'user_code' => null,
                                'voucher_name' => 'Coupon Code Activated',
                                'voucher_owner_name' => \App\User::find(\App\UserCouponCode::where('code',$request->code)->first()->user_id)->name." ".\App\User::find(\App\UserCouponCode::where('code',$request->code)->first()->user_id)->last_name,
                                'booking_items' => view('pages.services.checkout_fetch.review_checkout',['discount_activate' => 'activated','data' => \App\Service::find($request->service_id)])->render(),
                                'booking_amount' => view('pages.services.checkout_fetch.booking_total',['discount_activate' => 'activated','data' => \App\Service::find($request->service_id)])->render(),
                                'booking_online_amount' => view('pages.services.checkout_fetch.online_pay',['discount_activate' => 'activated','data' => \App\Service::find($request->service_id)])->render(),
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
                                'text' => "As a Partner, you are now entitled to a lifetime discount of up to 20% on all service reservations and product purchases.",
                                'voucher_owner' => \App\User::where('user_code',$request->code)->first(),
                                'voucher_owner_id' => \App\User::where('user_code',$request->code)->first()->employee->id,
                                'coupon_id' => null,
                                'user_code' => $request->code,
                                'user_code_id' => \App\User::where('user_code',$request->code)->first()->id,
                                'voucher_name' => 'Coupon Code Activated',
                                'voucher_owner_name' => \App\User::where('user_code',$request->code)->first()->name." ".\App\User::where('user_code',$request->code)->first()->last_name,
                                'booking_items' => view('pages.services.checkout_fetch.review_checkout',['discount_activate' => 'activated','data' => \App\Service::find($request->service_id)])->render(),
                                'booking_amount' => view('pages.services.checkout_fetch.booking_total',['discount_activate' => 'activated','data' => \App\Service::find($request->service_id)])->render(),
                                'booking_online_amount' => view('pages.services.checkout_fetch.online_pay',['discount_activate' => 'activated','data' => \App\Service::find($request->service_id)])->render(),
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
            'booking_items' => view('pages.services.checkout_fetch.review_checkout',['discount_activate' => null,'data' => \App\Service::find($request->service_id)])->render(),
            'booking_amount' => view('pages.services.checkout_fetch.booking_total',['discount_activate' => null,'data' => \App\Service::find($request->service_id)])->render(),
            'booking_online_amount' => view('pages.services.checkout_fetch.online_pay',['discount_activate' => null,'data' => \App\Service::find($request->service_id)])->render(),
        ]);
    }

    public function make_reservation_by_points(Request $request){

        $this->validate($request, [
            'book_reference'=>'required',
            'book_date' => 'required',
            'book_time' => 'required',
            'service_id' => 'required',
            'user_id' => 'required',
            'price' => 'required',
            'payment_method' => 'required',
        ]);
        //:store booking details
        $table=\App\Service_booking::create($request->all());
        //:store booking customer details
        \App\Service_booking_customer::create([
            'booking_id' => \App\Service_booking::orderby('created_at','Desc')->first()->id,
            'name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'contact' => $request->input('user_contact'),
            'nic' => $request->input('user_nic'),
            'note' => $request->input('user_note'),
        ]);
        $table_booking = \App\Service_booking::orderby('created_at','Desc')->first();
        //:store booking payment details
        $table_payment=\App\Payments::create($request->all());
        $table_payment->type = "service";
        $table_payment->booking_id = $table_booking->id;
        $table_payment->payment_status = "success";
        $table_payment->save();

        //:: update shipping amount to site wallet
        \App\Points_Commission::create([
            'user_id' => \App\User::Where('prefix','Site')->first()->id,
            'booking_id' => $table_booking->id,
            'type' => 'Site',
            'commission_points' => ($table_booking->payment->paid_points? $table_booking->payment->paid_points : 0),
            'week' => \Carbon\Carbon::now()->format('W'),
            'pay_type' => "Reservation"
        ]);
        \App\Points::create([
            'user_id' => \App\User::Where('prefix','Site')->first()->id,
            'booking_id' => $table_booking->id,
            'direct_points' => ($table_booking->payment->paid_points? $table_booking->payment->paid_points : 0),
            'week' => \Carbon\Carbon::now()->format('W')
        ]);

        if($request->input('voucher_id')){
            $table_voucher=\App\Voucher_customers::create($request->all());
            $table_voucher->user_id = $request->input('user_id');
            $table_voucher->booking_id = $table_booking->id;
            $table_voucher->save();
            \App\Voucher_customers::find($table_voucher->id)->notify(new NewVoucher($table_voucher));
        }

        if($request->input('voucher_provide_by') && $request->input('voucher_provide_by') != 0){
            if(!\auth::user()->employee){
                \App\Agent::create([
                    'user_id' => \auth::user()->id,
                    'ref_id' => $request->input('voucher_provide_by'),
                    'intro_id' => $request->input('voucher_provide_by'),
                    'placement_id' => $request->input('voucher_provide_by'),
                ]);
                \App\User::where('id',\auth::user()->id)->update([
                    'agent_id' => \App\Agent::where('user_id',\auth::user()->id)->first()->id,
                    'request_referral' => $request->input('voucher_provide_by'),
                    'agent_status' => "Approved",
                    'agent_request_date' => \Carbon\Carbon::now(),
                    'is_partner_voucher_request' => \Carbon\Carbon::now(),
                    'is_invited' => $request->input('voucher_provide_by'),
                ]);
                \App\Emp_friends_invite::create([
                    'agent_id' => $request->input('voucher_provide_by'),
                    'user_id' => \auth::user()->id,
                ]);
                $success_msg = $request->input('voucher_provide_by');
            }
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
                    'order_id' => null,
                    'booking_id' => $table->id,
                ]);
                $success_msg = $request->input('voucher_ref_by');
            }
        }

        \App\Service_booking::find($table->id)->notify(new NewBooking($table));
        $data = \App\Service_booking::find($table->id);
        \Mail::send('emails.booking_notification', ['data'=>$data], function($message) use ($data){
            $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
            $message->to(\App\Details::where('key','company_email')->first()->value);
            $message->subject(\config('app.name').' Service Reservation Notification');
        });
        return redirect()->route('services.booking.done')->with('success_reservation','success');
    }

    public function services_booking_payment_success(Request $request){

        $merchant_id        = $request->input('merchant_id');
        $order_id           = $request->input('order_id');
        $payhere_amount     = $request->input('payhere_amount');
        $payhere_currency   = $request->input('payhere_currency');
        $status_code        = $request->input('status_code');
        $md5sig             = $request->input('md5sig');
        $merchant_secret    = '8bQZFzjOxAh8hf6XkaeaYL8QfoeMKXNgr4uXIRlaUHOX';
        $local_md5sig = strtoupper (md5 ( $merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret)) ) );
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
        //:store booking details

        if(in_array($order_id, \App\Service_booking::pluck('book_reference')->toArray())){

        }else {
            $table_booking = \App\Service_booking::create($request->all());
            $table_booking->book_reference = $order_id;
            $table_booking->save();
            //:store booking customer details
            \App\Service_booking_customer::create([
                'booking_id' => \App\Service_booking::orderby('created_at', 'Desc')->firstOrfail()->id,
                'name' => $request->input('customer_name'),
                'last_name' => $request->input('customer_last_name'),
                'email' => $request->input('customer_email'),
                'contact' => $request->input('customer_contact'),
                'nic' => $request->input('customer_nic'),
                'a_question_one' => \App\Service::find($request->input('service_id'))->a_question_one,
                'a_question_two' => \App\Service::find($request->input('service_id'))->a_question_two,
                'a_question_three' => \App\Service::find($request->input('service_id'))->a_question_three,
                'a_answer_one' => $request->input('customer_answer_one'),
                'a_answer_two' => $request->input('customer_answer_two'),
                'a_answer_three' => $request->input('customer_answer_three'),
                'note' => $request->input('customer_note'),
            ]);

            $table_booking = \App\Service_booking::orderby('created_at', 'Desc')->first();

            //:store booking payment details
            \App\Payments::create([
                'type' => "service",
                'user_id' => $request->input('user_id'),
                'order_id' => null,
                'booking_id' => $table_booking->id,
                'payment_status' => 'success',
                'payment_method' => $request->input('payment_method'),
                'paid_amount' => $request->input('paid_amount'),
                'payment_signature' => $local_md5sig,
            ]);

            //:: update shipping amount to site wallet
            \App\Points_Commission::create([
                'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
                'booking_id' => $table_booking->id,
                'type' => 'Site',
                'commission_points' => (($table_booking->payment->paid_points ? $table_booking->payment->paid_points : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'amount' => $table_booking->payment->paid_amount,
                'week' => \Carbon\Carbon::now()->format('W'),
                'pay_type' => "Reservation"
            ]);
            \App\Points::create([
                'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
                'booking_id' => $table_booking->id,
                'direct_points' => (($table_booking->payment->paid_points ? $table_booking->payment->paid_points : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'week' => \Carbon\Carbon::now()->format('W')
            ]);

            if ($request->input('voucher_id')) {
                $table_voucher = \App\Voucher_customers::create([
                    'voucher_id' => $request->input('voucher_id'),
                    'user_id' => $request->input('user_id'),
                    'booking_id' => $table_booking->id,
                ]);
                \App\Voucher_customers::find($table_voucher->id)->notify(new NewVoucher($table_voucher));
            }

            if ($request->input('voucher_provide_by') && $request->input('voucher_provide_by') != 0) {
                if (!\auth::user()->employee) {
                    \App\Agent::create([
                        'user_id' => \auth::user()->id,
                        'ref_id' => $request->input('voucher_provide_by'),
                        'intro_id' => $request->input('voucher_provide_by'),
                        'placement_id' => $request->input('voucher_provide_by'),
                    ]);
                    \App\User::where('id', \auth::user()->id)->update([
                        'agent_id' => \App\Agent::where('user_id', \auth::user()->id)->first()->id,
                        'request_referral' => $request->input('voucher_provide_by'),
                        'agent_status' => "Approved",
                        'agent_request_date' => \Carbon\Carbon::now(),
                        'is_partner_voucher_request' => \Carbon\Carbon::now(),
                        'is_invited' => $request->input('voucher_provide_by'),
                    ]);
                    \App\Emp_friends_invite::create([
                        'agent_id' => $request->input('voucher_provide_by'),
                        'user_id' => \auth::user()->id,
                    ]);
                    $success_msg = $request->input('voucher_provide_by');
                }
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
                        'user_code' => \App\User::find($request->input('uc'))->user_code,
                        'booking_id' => $table_booking->id,
                    ]);
                    $success_msg = $request->input('voucher_ref_by');
                }
            }

            \App\Service_booking::find($table_booking->id)->notify(new NewBooking($table_booking));
            $data = \App\Service_booking::find($table_booking->id);
            \Mail::send('emails.booking_notification', ['data'=>$data], function($message) use ($data){
                $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
                $message->to(\App\Details::where('key','company_email')->first()->value);
                $message->subject(\config('app.name').' Service Reservation Notification');
            });
        }
        return redirect()->route('services.booking.done')->with('success_reservation','success');
    }

    public function services_booking_payment_failed(Request $request){

        return view('pages.services.booking_failed');
    }

    public function services_reservations_success(){
        if (\Session::has('success_reservation')){
            return view('pages.services.booking_success');
        }else{
            return redirect()->route('home');
        }
    }

    public function check_reservation(Request $request){
        $status="success";
        $booked_time=null;
        $duration_buffer_minutes=null;

        $table_service=\App\Service::find($request->service_id);
        if(\App\Service_booking::where('service_id',$request->service_id)->where('status','Pending')->where('book_date',$request->book_date)->where('book_time',$request->time)->first()){ $status = "failed"; }
        elseif(\App\Service_booking::where('service_id',$request->service_id)->where('status','Confirmed')->where('book_date',$request->book_date)->where('book_time',$request->time)->first()){ $status = "failed"; }
        else{

            $table_pending = \App\Service_booking::where('service_id',$request->service_id)->where('status','Pending')->where('book_date',$request->book_date)->first();
            $table_confirm = \App\Service_booking::where('service_id',$request->service_id)->where('status','Confirmed')->where('book_date',$request->book_date)->first();
            if($table_pending){
                $booked_time = date('h:i A',strtotime($table_pending->book_time));
            }
            if($table_confirm){
                $booked_time = date('h:i A', strtotime($table_confirm->book_time));
            }

            $table_pending_doctors = \App\Service_booking::where('status','Pending')->where('book_date',$request->book_date)->get();
            $table_confirm_doctors = \App\Service_booking::where('status','Confirmed')->where('book_date',$request->book_date)->get();

            if($table_pending_doctors){
                foreach ($table_pending_doctors as $row){
                    if($row->service->doctor->id == $table_service->doctor_id){
                        $doctor_booked_time = date('h:i A',strtotime($row->book_time));
                        $duration_hour=$row->service->duration_hour;
                        $duration_minutes=$row->service->duration_minutes;
                        $duration_buffer_minutes=($row->service->buffer_time)? $row->service->buffer_time : 0;

                        if(($this->add_time($doctor_booked_time,(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes) > date('h:i A',strtotime($request->time))) && ($doctor_booked_time < $this->add_time(date('h:i A',strtotime($request->time)),(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes))){
                            $status = "failed_time";
                        }
                    }
                }
            }
            if($table_confirm_doctors){
                foreach ($table_confirm_doctors as $row){
                    if($row->service->doctor->id == $table_service->doctor_id){
                        $doctor_booked_time = date('h:i A',strtotime($row->book_time));
                        $duration_hour=$row->service->duration_hour;
                        $duration_minutes=$row->service->duration_minutes;
                        $duration_buffer_minutes=($row->service->buffer_time)? $row->service->buffer_time : 0;
                        if(($this->add_time($doctor_booked_time,(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes) > date('h:i A',strtotime($request->time))) && ($doctor_booked_time < $this->add_time(date('h:i A',strtotime($request->time)),(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes))){
                            $status = "failed_time";
                        }
                    }
                }
            }


            if($booked_time){
                $duration_hour=$table_service->duration_hour;
                $duration_minutes=$table_service->duration_minutes;
                $duration_buffer_minutes=($table_service->buffer_time)? $table_service->buffer_time : 0;
                if(($this->add_time($booked_time,(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes) > date('h:i A',strtotime($request->time))) && ($booked_time < $this->add_time(date('h:i A',strtotime($request->time)),(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes))){
                    $status = "failed_time";
                }
            }

            //$status = $booked_time;
            //$status = "added time: ".$this->add_time($booked_time,(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes);
        }
        return response()->json($status);
    }

    function add_time($time,$plusHour,$plusMinutes){

        $endTime = strtotime("+{$plusHour} hours +{$plusMinutes} minutes", strtotime($time));
        return date('h:i A', $endTime);
    }

    public function get_book_times(Request $request){
        $booked_time = null;
        $booked_time_addition =null;
        $table_pending = \App\Service_booking::where('status','Pending')->where('book_date',$request->selected_time)->first();
        $table_confirm = \App\Service_booking::where('status','Confirmed')->where('book_date',$request->selected_time)->first();
        if($table_pending){
            $booked_time = date('h:i A',strtotime($table_pending->book_time));
            $duration_hour=$table_pending->service->duration_hour;
            $duration_minutes=$table_pending->service->duration_minutes;
            $duration_buffer_minutes=($table_pending->service->buffer_time)? $table_pending->service->buffer_time : 0;
            $booked_time_addition = $this->add_time($booked_time,(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes);
        }
        if($table_confirm){
            $booked_time = date('h:i A', strtotime($table_confirm->book_time));
            $duration_hour=$table_confirm->service->duration_hour;
            $duration_minutes=$table_confirm->service->duration_minutes;
            $duration_buffer_minutes=($table_confirm->service->buffer_time)? $table_confirm->service->buffer_time : 0;
            $booked_time_addition = $this->add_time($booked_time,(($duration_hour)? $duration_hour : 0),(($duration_minutes)? $duration_minutes : 0) + $duration_buffer_minutes);

        }

        return response()->json([
            'time_view' => view('pages.services.booking_time_slot',[
                'selected_time'=>$request->selected_time,
                'booked_time' =>$booked_time,
                'booked_time_addition' => $booked_time_addition
            ])->render()
        ]);
    }
}
