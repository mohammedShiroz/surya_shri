<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;


class BookingController extends Controller
{
    public function __construct()
    {
        \App\Service_booking::observe(ActivityLogObserver::class);
    }


    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_booking(),
            'property' => ['name' => 'Check Service Reservations List'],
            'type' => 'Read',
            'log' => 'Check Service Reservations List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.services.bookings.index');
    }

    public function pending_bookings()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_booking(),
            'property' => ['name' => 'Check Service Pending Reservations List'],
            'type' => 'Read',
            'log' => 'Check Service Pending Reservations List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.services.bookings.pending_bookings');
    }

    public function confirmed_bookings()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_booking(),
            'property' => ['name' => 'Check Service Confirmed Reservations List'],
            'type' => 'Read',
            'log' => 'Check Service Confirmed Reservations List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.services.bookings.confirmed_bookings');
    }

    public function canceled_bookings()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_booking(),
            'property' => ['name' => 'Check Service Canceled Reservations List'],
            'type' => 'Read',
            'log' => 'Check Service Canceled Reservations List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.services.bookings.canceled_bookings');
    }

    public function rejected_bookings()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_booking(),
            'property' => ['name' => 'Check Service Rejected Reservations List'],
            'type' => 'Read',
            'log' => 'Check Service Rejected Reservations List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.services.bookings.rejected_bookings');
    }

    public function expired_bookings()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_booking(),
            'property' => ['name' => 'Check Service Expired Reservations List'],
            'type' => 'Read',
            'log' => 'Check Service Expired Reservations List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.services.bookings.expired_bookings');
    }

    public function completed_bookings()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_booking(),
            'property' => ['name' => 'Check Service Completed Reservations List'],
            'type' => 'Read',
            'log' => 'Check Service Completed Reservations List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.services.bookings.completed_bookings');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function add_notes(Request $request){
        $this->validate($request,[
            'additional' => 'required'
        ]);
        $table=\App\BookingAdditionalNotes::create($request->all());
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\BookingAdditionalNotes(),
            'property' => \App\BookingAdditionalNotes::find($table->id),
            'type' => 'Create',
            'log' => 'Create Reservations Note Created By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',"SSA/BK/".\App\Service_booking::find($request->input('booking_id'))->book_reference." reservation additional note has been added");
    }

    public function delete_notes($id){
        \App\BookingAdditionalNotes::where('id',$id)->update(['is_deleted'=> \Carbon\Carbon::now()]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\BookingAdditionalNotes(),
            'property' => \App\BookingAdditionalNotes::find($id),
            'type' => 'Delete',
            'log' => 'Delete Reservations Note Delete By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',"SSA/BK/".\App\BookingAdditionalNotes::find($id)->booking->book_reference." reservation additional note has been deleted");
    }

    public function show($id)
    {
        if(\App\Service_booking::find(HashDecode($id))){
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service_booking(),
                'property' => \App\Service_booking::find(HashDecode($id)),
                'type' => 'Read',
                'log' => 'Check Service Reservations Details Read By ' . \Auth::user()->name,
            ]));

            return view('backend.services.bookings.view',[
                'data' => \App\Service_booking::find(HashDecode($id))
            ]);
        }

        if(\App\Service_booking::find($id)){
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service_booking(),
                'property' => \App\Service_booking::find($id),
                'type' => 'Read',
                'log' => 'Check Service Reservations Details Read By ' . \Auth::user()->name,
            ]));

            return view('backend.services.bookings.view',[
                'data' => \App\Service_booking::find($id)
            ]);
        }

    }

    function completed_book($id){
        $data=\App\Service_booking::where('id',$id)->first();
        if($data->status != "Completed") {
            $data->update(['status' => 'Completed']);
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service_booking(),
                'property' => \App\Service_booking::find($id),
                'type' => 'Update',
                'log' => 'Change Reservations Status "Booking Completed". Changed By ' . \Auth::user()->name,
            ]));

            $table = \App\Service_booking::find($id);
            if ($table->user->employee) {
                //:Update User Points
                $user_ids = null;
                $aff = array();
                if (strlen(\App\Agent::Where('id', $table->user->employee->id)->first()->parents_without_user()) > 1) {
                    $user_ids = substr(\App\Agent::Where('id', $table->user->employee->id)->first()->parents_without_user(), 0, -1);
                } else {
                    $user_ids = \App\Agent::Where('id', $table->user->employee->id)->first()->parents_without_user();
                }
                foreach (range(0, 3) as $k) {
                    if ($k == 0) {
                        if (isset(array_reverse(explode(',', $user_ids))[0])) {
                            \App\Points_Commission::create([
                                'agent_id' => $table->user->employee->id,
                                'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[0])->user->id,
                                'booking_id' => $table->id,
                                'service_id' => $table->service_id,
                                'commission_points' => ($table->service->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'amount' => $table->service->first_level_commission_price,
                                'week' => \Carbon\Carbon::now()->format('W'),
                                'pay_type' => "Service Commission"
                            ]);
                            \App\Points::create([
                                'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[0])->user->id,
                                'booking_id' => $table->id,
                                'in_direct_points' => ($table->service->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'week' => \Carbon\Carbon::now()->format('W')
                            ]);
                        } else {
                            //::Update 1st affiliate points to company
                            \App\Points_Commission::create([
                                'agent_id' => null,
                                'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                'booking_id' => $table->id,
                                'service_id' => $table->service_id,
                                'commission_points' => ($table->service->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'amount' => $table->service->first_level_commission_price,
                                'week' => \Carbon\Carbon::now()->format('W'),
                                'pay_type' => "Service First Level Affiliate Commission"
                            ]);
                            \App\Points::create([
                                'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                'booking_id' => $table->id,
                                'in_direct_points' => ($table->service->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'week' => \Carbon\Carbon::now()->format('W')
                            ]);
                        }

                    }
                    if ($k == 1) {
                        if (isset(array_reverse(explode(',', $user_ids))[1])) {
                            \App\Points_Commission::create([
                                'agent_id' => $table->user->employee->id,
                                'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[1])->user->id,
                                'booking_id' => $table->id,
                                'service_id' => $table->service_id,
                                'commission_points' => ($table->service->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'amount' => $table->service->second_level_commission_price,
                                'week' => \Carbon\Carbon::now()->format('W'),
                                'pay_type' => "Service Commission"

                            ]);
                            \App\Points::create([
                                'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[1])->user->id,
                                'booking_id' => $table->id,
                                'in_direct_points' => ($table->service->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'week' => \Carbon\Carbon::now()->format('W')
                            ]);
                        } else {
                            //::Update 2nd affiliate points to company
                            \App\Points_Commission::create([
                                'agent_id' => null,
                                'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                'booking_id' => $table->id,
                                'service_id' => $table->service_id,
                                'commission_points' => ($table->service->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'amount' => $table->service->second_level_commission_price,
                                'week' => \Carbon\Carbon::now()->format('W'),
                                'pay_type' => "Service Second Level Affiliate Commission"

                            ]);
                            \App\Points::create([
                                'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                'booking_id' => $table->id,
                                'in_direct_points' => ($table->service->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'week' => \Carbon\Carbon::now()->format('W')
                            ]);
                        }
                    }
                    if ($k == 2) {
                        if (isset(array_reverse(explode(',', $user_ids))[2])) {
                            \App\Points_Commission::create([
                                'agent_id' => $table->user->employee->id,
                                'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[2])->user->id,
                                'booking_id' => $table->id,
                                'service_id' => $table->service_id,
                                'commission_points' => ($table->service->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'amount' => $table->service->third_level_commission_price,
                                'week' => \Carbon\Carbon::now()->format('W'),
                                'pay_type' => "Service Commission"
                            ]);
                            \App\Points::create([
                                'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[2])->user->id,
                                'booking_id' => $table->id,
                                'in_direct_points' => ($table->service->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'week' => \Carbon\Carbon::now()->format('W')
                            ]);
                        } else {
                            //::Update 3rd affiliate points to company
                            \App\Points_Commission::create([
                                'agent_id' => null,
                                'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                'booking_id' => $table->id,
                                'service_id' => $table->service_id,
                                'commission_points' => ($table->service->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'amount' => $table->service->third_level_commission_price,
                                'week' => \Carbon\Carbon::now()->format('W'),
                                'pay_type' => "Service Third Level Affiliate Commission"
                            ]);
                            \App\Points::create([
                                'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                'booking_id' => $table->id,
                                'in_direct_points' => ($table->service->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'week' => \Carbon\Carbon::now()->format('W')
                            ]);
                        }
                    }
                    if ($k == 3) {
                        if (isset(array_reverse(explode(',', $user_ids))[3])) {
                            \App\Points_Commission::create([
                                'agent_id' => $table->user->employee->id,
                                'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[3])->user->id,
                                'booking_id' => $table->id,
                                'service_id' => $table->service_id,
                                'commission_points' => ($table->service->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'amount' => $table->service->fourth_level_commission_price,
                                'week' => \Carbon\Carbon::now()->format('W'),
                                'pay_type' => "Service Commission"
                            ]);
                            \App\Points::create([
                                'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[3])->user->id,
                                'booking_id' => $table->id,
                                'in_direct_points' => ($table->service->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'week' => \Carbon\Carbon::now()->format('W')
                            ]);
                        } else {

                            //::Update 4th affiliate points to company
                            \App\Points_Commission::create([
                                'agent_id' => null,
                                'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                'booking_id' => $table->id,
                                'service_id' => $table->service_id,
                                'commission_points' => ($table->service->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'amount' => $table->service->fourth_level_commission_price,
                                'week' => \Carbon\Carbon::now()->format('W'),
                                'pay_type' => "Service Fourth Level Affiliate Commission"
                            ]);
                            \App\Points::create([
                                'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                'booking_id' => $table->id,
                                'in_direct_points' => ($table->service->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                'week' => \Carbon\Carbon::now()->format('W')
                            ]);
                        }
                    }
                }
            } else {

                //::Update 1st affiliate points to company
                \App\Points_Commission::create([
                    'agent_id' => null,
                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                    'booking_id' => $table->id,
                    'service_id' => $table->service_id,
                    'commission_points' => ($table->service->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'amount' => $table->service->first_level_commission_price,
                    'week' => \Carbon\Carbon::now()->format('W'),
                    'pay_type' => "Service First Level Affiliate Commission"
                ]);
                \App\Points::create([
                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                    'booking_id' => $table->id,
                    'in_direct_points' => ($table->service->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'week' => \Carbon\Carbon::now()->format('W')
                ]);

                //::Update 2nd affiliate points to company
                \App\Points_Commission::create([
                    'agent_id' => null,
                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                    'booking_id' => $table->id,
                    'service_id' => $table->service_id,
                    'commission_points' => ($table->service->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'amount' => $table->service->second_level_commission_price,
                    'week' => \Carbon\Carbon::now()->format('W'),
                    'pay_type' => "Service Second Level Affiliate Commission"

                ]);
                \App\Points::create([
                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                    'booking_id' => $table->id,
                    'in_direct_points' => ($table->serrvice->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'week' => \Carbon\Carbon::now()->format('W')
                ]);

                //::Update 3rd affiliate points to company
                \App\Points_Commission::create([
                    'agent_id' => null,
                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                    'booking_id' => $table->id,
                    'service_id' => $table->service_id,
                    'commission_points' => ($table->service->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'amount' => $table->service->third_level_commission_price,
                    'week' => \Carbon\Carbon::now()->format('W'),
                    'pay_type' => "Service Third Level Affiliate Commission"
                ]);
                \App\Points::create([
                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                    'booking_id' => $table->id,
                    'in_direct_points' => ($table->service->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'week' => \Carbon\Carbon::now()->format('W')
                ]);

                //::Update 4th affiliate points to company
                \App\Points_Commission::create([
                    'agent_id' => null,
                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                    'booking_id' => $table->id,
                    'service_id' => $table->service_id,
                    'commission_points' => ($table->service->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'amount' => $table->service->fourth_level_commission_price,
                    'week' => \Carbon\Carbon::now()->format('W'),
                    'pay_type' => "Service Fourth Level Affiliate Commission"
                ]);
                \App\Points::create([
                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                    'booking_id' => $table->id,
                    'in_direct_points' => ($table->service->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'week' => \Carbon\Carbon::now()->format('W')
                ]);
            }
            //::Update Global Points
            \App\Points_Commission::create([
                'user_id' => \App\User::Where('prefix', 'Global')->first()->id,
                'booking_id' => $table->id,
                'service_id' => $table->service_id,
                'type' => 'Global',
                'commission_points' => (($table->service->fifth_level_commission_price ? $table->service->fifth_level_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'amount' => $table->service->fifth_level_commission_price,
                'week' => \Carbon\Carbon::now()->format('W'),
                'pay_type' => "Service Commission"
            ]);
            \App\Points::create([
                'user_id' => \App\User::Where('prefix', 'Global')->first()->id,
                'booking_id' => $table->id,
                'direct_points' => (($table->service->fifth_level_commission_price ? $table->service->fifth_level_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'week' => \Carbon\Carbon::now()->format('W')
            ]);
            //::Update site expenses commission points
            \App\Points_Commission::create([
                'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
                'booking_id' => $table->id,
                'type' => 'Site',
                'service_id' => $table->service_id,
                'commission_points' => (($table->service->expenses_commission_price ? $table->service->expenses_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'amount' => $table->service->expenses_commission_price,
                'week' => \Carbon\Carbon::now()->format('W'),
                'pay_type' => "Service Commission"
            ]);
            \App\Points::create([
                'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
                'booking_id' => $table->id,
                'direct_points' => (($table->service->expenses_commission_price ? $table->service->expenses_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'week' => \Carbon\Carbon::now()->format('W')
            ]);

            //::Update Bonus Points
            \App\Points_Commission::create([
                'user_id' => \App\User::Where('prefix', 'Bonus')->first()->id,
                'booking_id' => $table->id,
                'type' => 'Bonus',
                'service_id' => $table->service_id,
                'commission_points' => (($table->service->bonus_commission_price ? $table->service->bonus_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'amount' => $table->service->bonus_commission_price,
                'week' => \Carbon\Carbon::now()->format('W'),
                'pay_type' => "Service Commission"
            ]);
            \App\Points::create([
                'user_id' => \App\User::Where('prefix', 'Bonus')->first()->id,
                'booking_id' => $table->id,
                'direct_points' => (($table->service->bonus_commission_price ? $table->service->bonus_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'week' => \Carbon\Carbon::now()->format('W')
            ]);
            //::Update Donations Points
            \App\Points_Commission::create([
                'user_id' => \App\User::Where('prefix', 'Donations')->first()->id,
                'booking_id' => $table->id,
                'type' => 'Donations',
                'service_id' => $table->service_id,
                'commission_points' => (($table->service->donations_commission_price ? $table->service->donations_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'amount' => $table->service->donations_commission_price,
                'week' => \Carbon\Carbon::now()->format('W'),
                'pay_type' => "Service Commission"
            ]);
            \App\Points::create([
                'user_id' => \App\User::Where('prefix', 'Donations')->first()->id,
                'booking_id' => $table->id,
                'direct_points' => (($table->service->donations_commission_price ? $table->service->donations_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'week' => \Carbon\Carbon::now()->format('W')
            ]);

            //:Update seller payment and points
            \App\Seller_points::create([
                'user_id' => \app\Agent::find($table->service->doctor_id)->user->id,
                'agent_id' => $table->service->doctor_id,
                'type' => 'Service',
                'booking_id' => $table->id,
                'service_id' => $table->service_id,
                'amount' => ($table->service->seller_paid_amount),
                'earn_points' => ($table->service->seller_paid_amount * (\App\Details::where('key', 'points_rate')->first()->amount)),
            ]);

            \App\Seller_payments::create([
                'partner_id' => $table->service->doctor_id,
                'user_id' => $table->user_id,
                'booking_id' => $table->id,
                'service_id' => $table->service_id,
                'paid_amount' => ($table->service->seller_paid_amount),
            ]);
            return redirect()->back()->with('success', $data->customer->name . " " . $data->customer->last_name . " Reservation has been Completed.");
        }else{
            return redirect()->back()->with('success', $data->customer->name . " " . $data->customer->last_name . " Reservation has been already completed.");
        }
    }
    function confirm_book($id){
        $data=\App\Service_booking::find($id);
        if($data->status != "Confirmed"){
            $data->update(['status'=>'Confirmed','confirmed_date' => \Carbon\Carbon::now()]);
            $user_email=$data->customer->email;
            //return view('backend.emails.book_confirmed',['data'=>$data]);
            \Mail::send('backend.emails.book_confirmed', ['data'=>$data], function($message) use ($user_email){
                $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
                $message->to($user_email);
                $message->subject(\config('app.name').' Service Reservation Confirmed');
            });

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service_booking(),
                'property' => \App\Service_booking::find($id),
                'type' => 'Update',
                'log' => 'Confirmed Reservations Status "Booking Confirmed". Confirmed By ' . \Auth::user()->name,
            ]));
            return redirect()->back()->with('success',$data->customer->name." ".$data->customer->last_name."'s Reservation has been Confirmed.");
        }else{
            return redirect()->back()->with('success',$data->customer->name." ".$data->customer->last_name."'s Reservation has been already Confirmed.");
        }
    }

    function reject_book(Request $request,$user_id,$id){

        $data=\App\Service_booking::find($id);
        if($data->status != "Rejected") {
            $data->update([
                'status' => 'Rejected',
                'rejected_date' => \Carbon\Carbon::now(),
                'reject_reason' => $request->input('reject_reason'),
            ]);
            $refund_points = null;
            if ($data->paid_points) {
                $refund_points = $data->paid_points;
            } else {
                $refund_points = ($data->paid_amount * (\App\Details::where('key', 'points_rate')->firstOrFail()->amount));
            }
            \App\Refund_points::create([
                'user_id' => $user_id,
                'booking_id' => $id,
                'refund_points' => $refund_points,
            ]);

//        return view('backend.emails.book_canceled',['data'=>$data]);
            $user_email = $data->customer->email;
            \Mail::send('backend.emails.book_canceled', ['data' => $data], function ($message) use ($user_email) {
                $message->from(\App\Details::where('key', 'company_email')->first()->value, \config('app.name'));
                $message->to($user_email);
                $message->subject(\config('app.name') . ' Service Reservation Canceled');
            });

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service_booking(),
                'property' => \App\Service_booking::find($id),
                'type' => 'Update',
                'log' => 'Rejected Reservations Status "Booking Rejected". Rejected By ' . \Auth::user()->name,
            ]));

            return redirect()->back()->with('success', $data->customer->name . " " . $data->customer->last_name . "'s Reservation has been Rejected.");
        }else{
            return redirect()->back()->with('success', $data->customer->name . " " . $data->customer->last_name . "'s Reservation has been already Rejected.");
        }
    }


    function cancel_book($id){

        $data=\App\Service_booking::find($id);
        if($data->status != "Canceled") {

            \App\Service_booking::where('id', $id)->update(['status' => 'Canceled', 'canceled_date' => \Carbon\Carbon::now()]);
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service_booking(),
                'property' => \App\Service_booking::find($id),
                'type' => 'Update',
                'log' => 'Canceled Reservations Status "Booking Cancel". Canceled By ' . \Auth::user()->name,
            ]));
            $user_email = $data->customer->email;
            \Mail::send('backend.emails.book_canceled', ['data' => $data], function ($message) use ($user_email) {
                $message->from(\App\Details::where('key', 'company_email')->first()->value, \config('app.name'));
                $message->to($user_email);
                $message->subject(\config('app.name') . ' Service Reservation Canceled');
            });
            return redirect()->back()->with('success', $data->customer->name . " " . $data->customer->last_name . "'s Reservation has been Canceled.");
        }else{
            return redirect()->back()->with('success', $data->customer->name . " " . $data->customer->last_name . "'s Reservation has been already Canceled.");
        }
    }

    function get_coming_up_bookings(){

        $dates=\App\Service_booking::where('status','confirmed')->whereDate('book_date', '>=', \Carbon\Carbon::today()->toDateString())->get();
        function rand_color() {
            return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        $data_events = array();
        $data_events[] = array(
            "end" => \Carbon\Carbon::today()->toDateString(),
            "start" => '1000-05-06',
            "display" => 'background',
            "backgroundColor" => '#cccccc',
            "allDay" => true
        );
        $get_color=null;
        foreach($dates as $row){
            $get_color=rand_color();
            $data_events[] = array(
                "id" => $row->id,
                "title" => $row->customer->name,
                "description" => $row->customer->name,
                "end" => $row->book_date,
                "start" => $row->book_date,
                "backgroundColor" => $get_color,
                "borderColor" => $get_color,
                "url" => route('reservations.show', $row->id)
            );
        }
        return response()->json($data_events);
        exit();
    }

    public function edit($id)
    {
        return view('backend.services.bookings.edit',[
            'data' => \App\Service_booking::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
           'book_date' => 'required',
           'book_time' => 'required',
           'old_book_date' => 'required',
           'old_book_time' => 'required',
        ]);
        $table=\App\Service_booking::find($id);
        $table->update([
            'old_book_date' =>$request->input('old_book_date'),
            'old_book_time' =>$request->input('old_book_time'),
            'book_date' =>$request->input('book_date'),
            'book_time' =>$request->input('book_time'),
        ]);
        return redirect()->back()->with('success', $table->customer->name." ".$table->customer->last_name."'s reservation date and time has been update.");
    }

    public function destroy($id)
    {
        $table=\App\Service_booking::where('id',$id)->first();
        \App\Service_booking::where('id',$id)->delete();
//        $table->update([
//            'is_deleted' => \Carbon\Carbon::now(),
//        ]);
        return redirect()->back()->with('success', $table->book_reference."'s reservation has been deleted.");
    }

    public function destroy_all(){

        foreach(\App\Service_booking::all() as $value){
            \App\Service_booking::where($value->id)->delete();
        }
        return redirect()->back()->with('success', "All reservation has been cleared.");
    }
}
