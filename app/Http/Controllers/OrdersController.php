<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Seller_payments;
use App\Seller_points;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Observers\ActivityLogObserver;

class OrdersController extends Controller
{
    public function __construct()
    {
        \App\Orders::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        if(\auth::user()->haspermission('read-orders')) {
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Orders(),
                'property' => ['name' => 'Check Orders List'],
                'type' => 'Read',
                'log' => 'Check Order List Read By ' . \Auth::user()->name,
            ]));
            return view('backend.orders.index');
        }
        abort(403);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show_order_details($id,$page_name)
    {
        if(\auth::user()->haspermission('read-orders')) {
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Orders(),
                'property' => \App\Orders::find(HashDecode($id)),
                'type' => 'Read',
                'log' => 'Check Orders Details Read By ' . \Auth::user()->name,
            ]));

            return view('backend.orders.view', [
                'data' => \App\Orders::find(HashDecode($id)),
                'page_name' => $page_name,
            ]);
        }
        abort(403);
    }

    public function add_notes(Request $request){
        $this->validate($request,[
           'additional' => 'required'
        ]);
        $table = \App\OrderAdditionalNotes::create($request->all());
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\OrderAdditionalNotes(),
            'property' => \App\OrderAdditionalNotes::find($table->id),
            'type' => 'Create',
            'log' => 'Create Order Note Created By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',"SSA/PO/".\App\Orders::find($request->input('order_id'))->track_id." Order additional note has been added");
    }

    public function delete_notes($id){
        \App\OrderAdditionalNotes::where('id',$id)->update(['is_deleted'=> \Carbon\Carbon::now()]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\OrderAdditionalNotes(),
            'property' => \App\OrderAdditionalNotes::find($id),
            'type' => 'Delete',
            'log' => 'Delete Order Note Delete By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',"SSA/PO/".\App\OrderAdditionalNotes::find($id)->order->track_id." Order additional note has been deleted");
    }

    public function show_pending_orders(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => ['name' => 'Check Pending Orders List'],
            'type' => 'Read',
            'log' => 'Check Pending Order List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.orders.pending');
    }

    public function show_completed_orders(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => ['name' => 'Check Completed Orders List'],
            'type' => 'Read',
            'log' => 'Check Completed Order List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.orders.completed');
    }

    public function show_confirmed_orders(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => ['name' => 'Check Confirmed Orders List'],
            'type' => 'Read',
            'log' => 'Check Confirmed Order List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.orders.confirmed');
    }

    public function show_rejected_orders(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => ['name' => 'Check Rejected Orders List'],
            'type' => 'Read',
            'log' => 'Check Rejected Order List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.orders.rejected');
    }

    public function show_canceled_orders(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => ['name' => 'Check Canceled Orders List'],
            'type' => 'Read',
            'log' => 'Check Canceled Order List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.orders.canceled');
    }

    public function show_pending_delivery(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => ['name' => 'Check Pending Deliveries Orders List'],
            'type' => 'Read',
            'log' => 'Check Pending Deliveries Order List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.orders.pending_deliveries');
    }

    public function reject_order(Request $request){
        $table=\App\Orders::find($request->input('order_id'));
        if($table->status !="Rejected") {
            $table->update([
                'status' => 'Rejected',
                'delivery_status' => 'Not-delivered',
                'rejected_date' => \Carbon\Carbon::now(),
                'reject_reason' => $request->input('reject_reason'),
            ]);

            $refund_points = null;
            if ($table->payment->paid_points) {
                $refund_points = $table->payment->paid_points;
            } else {
                $refund_points = ($table->payment->paid_amount * (\App\Details::where('key', 'points_rate')->first()->amount));
            }


            //: increase the stock from reject order item
            foreach ($table->items as $item) {
                $table_product = \App\Products::where('id', $item->product_id)->first();
                $table_product->update([
                    'stock' => ($table_product->stock + $item->qty)
                ]);
            }

            \App\Refund_points::create([
                'user_id' => $table->user->id,
                'order_id' => $table->id,
                'refund_points' => $refund_points,
            ]);

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Orders(),
                'property' => \App\Orders::find($request->input('order_id')),
                'type' => 'Update',
                'log' => 'Reject Order. Rejected By ' . \Auth::user()->name,
            ]));
            return redirect()->back()->with('success', $table->customer->name . "'s order has been rejected. and refund paid amount or points.");
        }else{
            return redirect()->back()->with('success', $table->customer->name . "'s order has been already rejected. and refund paid amount or points.");
        }
    }

    public function confirm_order(Request $request){

        $table=\App\Orders::find($request->input('order_id'));
        if($table->status !="Confirmed") {
            $table->update([
                'status' => 'Confirmed',
                'confirmed_date' => \Carbon\Carbon::now(),
            ]);
            foreach ($table->items as $item) {
                $table_product = \App\Products::find($item->product_id);
                $table_product->update([
                    'sold' => ($table_product->sold + $item->qty)
                ]);
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
                                    'order_id' => $table->id,
                                    'product_id' => $table_product->id,
                                    'commission_points' => ($table_product->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'amount' => $table_product->first_level_commission_price,
                                    'week' => \Carbon\Carbon::now()->format('W'),
                                    'pay_type' => "Product Commission"
                                ]);
                                \App\Points::create([
                                    'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[0])->user->id,
                                    'order_id' => $table->id,
                                    'in_direct_points' => ($table_product->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'week' => \Carbon\Carbon::now()->format('W')
                                ]);
                            } else {
                                //::Update 1st affiliate points to company
                                \App\Points_Commission::create([
                                    'agent_id' => null,
                                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                    'order_id' => $table->id,
                                    'product_id' => $table_product->id,
                                    'commission_points' => ($table_product->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'amount' => $table_product->first_level_commission_price,
                                    'week' => \Carbon\Carbon::now()->format('W'),
                                    'pay_type' => "Product First Level Affiliate Commission"
                                ]);
                                \App\Points::create([
                                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                    'order_id' => $table->id,
                                    'in_direct_points' => ($table_product->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'week' => \Carbon\Carbon::now()->format('W')
                                ]);
                            }

                        }
                        if ($k == 1) {
                            if (isset(array_reverse(explode(',', $user_ids))[1])) {
                                \App\Points_Commission::create([
                                    'agent_id' => $table->user->employee->id,
                                    'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[1])->user->id,
                                    'order_id' => $table->id,
                                    'product_id' => $table_product->id,
                                    'commission_points' => ($table_product->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'amount' => $table_product->second_level_commission_price,
                                    'week' => \Carbon\Carbon::now()->format('W'),
                                    'pay_type' => "Product Commission"

                                ]);
                                \App\Points::create([
                                    'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[1])->user->id,
                                    'order_id' => $table->id,
                                    'in_direct_points' => ($table_product->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'week' => \Carbon\Carbon::now()->format('W')
                                ]);
                            } else {
                                //::Update 2nd affiliate points to company
                                \App\Points_Commission::create([
                                    'agent_id' => null,
                                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                    'order_id' => $table->id,
                                    'product_id' => $table_product->id,
                                    'commission_points' => ($table_product->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'amount' => $table_product->second_level_commission_price,
                                    'week' => \Carbon\Carbon::now()->format('W'),
                                    'pay_type' => "Product Second Level Affiliate Commission"

                                ]);
                                \App\Points::create([
                                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                    'order_id' => $table->id,
                                    'in_direct_points' => ($table_product->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'week' => \Carbon\Carbon::now()->format('W')
                                ]);
                            }
                        }
                        if ($k == 2) {
                            if (isset(array_reverse(explode(',', $user_ids))[2])) {
                                \App\Points_Commission::create([
                                    'agent_id' => $table->user->employee->id,
                                    'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[2])->user->id,
                                    'order_id' => $table->id,
                                    'product_id' => $table_product->id,
                                    'commission_points' => ($table_product->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'amount' => $table_product->third_level_commission_price,
                                    'week' => \Carbon\Carbon::now()->format('W'),
                                    'pay_type' => "Product Commission"
                                ]);
                                \App\Points::create([
                                    'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[2])->user->id,
                                    'order_id' => $table->id,
                                    'in_direct_points' => ($table_product->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'week' => \Carbon\Carbon::now()->format('W')
                                ]);
                            } else {
                                //::Update 3rd affiliate points to company
                                \App\Points_Commission::create([
                                    'agent_id' => null,
                                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                    'order_id' => $table->id,
                                    'product_id' => $table_product->id,
                                    'commission_points' => ($table_product->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'amount' => $table_product->third_level_commission_price,
                                    'week' => \Carbon\Carbon::now()->format('W'),
                                    'pay_type' => "Product Third Level Affiliate Commission"
                                ]);
                                \App\Points::create([
                                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                    'order_id' => $table->id,
                                    'in_direct_points' => ($table_product->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'week' => \Carbon\Carbon::now()->format('W')
                                ]);
                            }
                        }
                        if ($k == 3) {
                            if (isset(array_reverse(explode(',', $user_ids))[3])) {
                                \App\Points_Commission::create([
                                    'agent_id' => $table->user->employee->id,
                                    'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[3])->user->id,
                                    'order_id' => $table->id,
                                    'product_id' => $table_product->id,
                                    'commission_points' => ($table_product->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'amount' => $table_product->fourth_level_commission_price,
                                    'week' => \Carbon\Carbon::now()->format('W'),
                                    'pay_type' => "Product Commission"
                                ]);
                                \App\Points::create([
                                    'user_id' => \App\Agent::find(array_reverse(explode(',', $user_ids))[3])->user->id,
                                    'order_id' => $table->id,
                                    'in_direct_points' => ($table_product->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'week' => \Carbon\Carbon::now()->format('W')
                                ]);
                            } else {

                                //::Update 4th affiliate points to company
                                \App\Points_Commission::create([
                                    'agent_id' => null,
                                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                    'order_id' => $table->id,
                                    'product_id' => $table_product->id,
                                    'commission_points' => ($table_product->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                                    'amount' => $table_product->fourth_level_commission_price,
                                    'week' => \Carbon\Carbon::now()->format('W'),
                                    'pay_type' => "Product Fourth Level Affiliate Commission"
                                ]);
                                \App\Points::create([
                                    'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                                    'order_id' => $table->id,
                                    'in_direct_points' => ($table_product->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
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
                        'order_id' => $table->id,
                        'product_id' => $table_product->id,
                        'commission_points' => ($table_product->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                        'amount' => $table_product->first_level_commission_price,
                        'week' => \Carbon\Carbon::now()->format('W'),
                        'pay_type' => "Product First Level Affiliate Commission"
                    ]);
                    \App\Points::create([
                        'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                        'order_id' => $table->id,
                        'in_direct_points' => ($table_product->first_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                        'week' => \Carbon\Carbon::now()->format('W')
                    ]);

                    //::Update 2nd affiliate points to company
                    \App\Points_Commission::create([
                        'agent_id' => null,
                        'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                        'order_id' => $table->id,
                        'product_id' => $table_product->id,
                        'commission_points' => ($table_product->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                        'amount' => $table_product->second_level_commission_price,
                        'week' => \Carbon\Carbon::now()->format('W'),
                        'pay_type' => "Product Second Level Affiliate Commission"

                    ]);
                    \App\Points::create([
                        'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                        'order_id' => $table->id,
                        'in_direct_points' => ($table_product->second_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                        'week' => \Carbon\Carbon::now()->format('W')
                    ]);

                    //::Update 3rd affiliate points to company
                    \App\Points_Commission::create([
                        'agent_id' => null,
                        'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                        'order_id' => $table->id,
                        'product_id' => $table_product->id,
                        'commission_points' => ($table_product->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                        'amount' => $table_product->third_level_commission_price,
                        'week' => \Carbon\Carbon::now()->format('W'),
                        'pay_type' => "Product Third Level Affiliate Commission"
                    ]);
                    \App\Points::create([
                        'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                        'order_id' => $table->id,
                        'in_direct_points' => ($table_product->third_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                        'week' => \Carbon\Carbon::now()->format('W')
                    ]);

                    //::Update 4th affiliate points to company
                    \App\Points_Commission::create([
                        'agent_id' => null,
                        'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                        'order_id' => $table->id,
                        'product_id' => $table_product->id,
                        'commission_points' => ($table_product->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                        'amount' => $table_product->fourth_level_commission_price,
                        'week' => \Carbon\Carbon::now()->format('W'),
                        'pay_type' => "Product Fourth Level Affiliate Commission"
                    ]);
                    \App\Points::create([
                        'user_id' => \App\User::Where('prefix', 'Company')->first()->id,
                        'order_id' => $table->id,
                        'in_direct_points' => ($table_product->fourth_level_commission_price * (\App\Details::where('key', 'points_rate')->first()->amount)),
                        'week' => \Carbon\Carbon::now()->format('W')
                    ]);
                }
                //::Update Global Points
                \App\Points_Commission::create([
                    'user_id' => \App\User::Where('prefix', 'Global')->first()->id,
                    'order_id' => $table->id,
                    'product_id' => $table_product->id,
                    'type' => 'Global',
                    'commission_points' => (($table_product->fifth_level_commission_price ? $table_product->fifth_level_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'amount' => $table_product->fifth_level_commission_price,
                    'week' => \Carbon\Carbon::now()->format('W'),
                    'pay_type' => "Product Commission"
                ]);
                \App\Points::create([
                    'user_id' => \App\User::Where('prefix', 'Global')->first()->id,
                    'order_id' => $table->id,
                    'direct_points' => (($table_product->fifth_level_commission_price ? $table_product->fifth_level_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'week' => \Carbon\Carbon::now()->format('W')
                ]);
                //::Update site expenses commission points
                \App\Points_Commission::create([
                    'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
                    'order_id' => $table->id,
                    'type' => 'Site',
                    'product_id' => $table_product->id,
                    'commission_points' => (($table_product->expenses_commission_price ? $table_product->expenses_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'amount' => $table_product->expenses_commission_price,
                    'week' => \Carbon\Carbon::now()->format('W'),
                    'pay_type' => "Product Commission"
                ]);
                \App\Points::create([
                    'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
                    'order_id' => $table->id,
                    'direct_points' => (($table_product->expenses_commission_price ? $table_product->expenses_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'week' => \Carbon\Carbon::now()->format('W')
                ]);

                //::Update Bonus Points
                \App\Points_Commission::create([
                    'user_id' => \App\User::Where('prefix', 'Bonus')->first()->id,
                    'order_id' => $table->id,
                    'type' => 'Bonus',
                    'product_id' => $table_product->id,
                    'commission_points' => (($table_product->bonus_commission_price ? $table_product->bonus_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'amount' => $table_product->bonus_commission_price,
                    'week' => \Carbon\Carbon::now()->format('W'),
                    'pay_type' => "Product Commission"
                ]);
                \App\Points::create([
                    'user_id' => \App\User::Where('prefix', 'Bonus')->first()->id,
                    'order_id' => $table->id,
                    'direct_points' => (($table_product->bonus_commission_price ? $table_product->bonus_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'week' => \Carbon\Carbon::now()->format('W')
                ]);
                //::Update Donations Points
                \App\Points_Commission::create([
                    'user_id' => \App\User::Where('prefix', 'Donations')->first()->id,
                    'order_id' => $table->id,
                    'type' => 'Donations',
                    'product_id' => $table_product->id,
                    'commission_points' => (($table_product->donations_commission_price ? $table_product->donations_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'amount' => $table_product->donations_commission_price,
                    'week' => \Carbon\Carbon::now()->format('W'),
                    'pay_type' => "Product Commission"
                ]);
                \App\Points::create([
                    'user_id' => \App\User::Where('prefix', 'Donations')->first()->id,
                    'order_id' => $table->id,
                    'direct_points' => (($table_product->donations_commission_price ? $table_product->donations_commission_price : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                    'week' => \Carbon\Carbon::now()->format('W')
                ]);

                //:Update seller payment and points
                \App\Seller_points::create([
                    'user_id' => \app\Agent::find($table_product->seller_id)->user->id,
                    'agent_id' => $table_product->seller_id,
                    'type' => 'Product',
                    'order_id' => $table->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'amount' => ($table_product->seller_paid_amount * $item->qty),
                    'earn_points' => (($table_product->seller_paid_amount * $item->qty) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                ]);

                \App\Seller_payments::create([
                    'partner_id' => $table_product->seller_id,
                    'user_id' => $table->user_id,
                    'order_id' => $table->id,
                    'product_id' => $item->product_id,
                    'paid_amount' => ($table_product->seller_paid_amount * $item->qty),
                ]);
            }

            //:: update shipping amount to site wallet
            \App\Points_Commission::create([
                'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
                'order_id' => $table->id,
                'type' => 'Site',
                'commission_points' => (($table->shipping_amount ? $table->shipping_amount : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'amount' => $table->shipping_amount,
                'week' => \Carbon\Carbon::now()->format('W'),
                'pay_type' => "Shipping Charge"
            ]);
            \App\Points::create([
                'user_id' => \App\User::Where('prefix', 'Site')->first()->id,
                'order_id' => $table->id,
                'direct_points' => (($table->shipping_amount ? $table->shipping_amount : 0) * (\App\Details::where('key', 'points_rate')->first()->amount)),
                'week' => \Carbon\Carbon::now()->format('W')
            ]);


            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Orders(),
                'property' => \App\Orders::find($request->input('order_id')),
                'type' => 'Update',
                'log' => 'Confirmed Order. Confirmed By ' . \Auth::user()->name,
            ]));

            return redirect()->back()->with('success', $table->customer->name . "'s order has been confirmed. Please be ready to send items.");
        }else{
            return redirect()->back()->with('success', $table->customer->name . "'s order has been already confirmed. Please be ready to send items.");
        }
    }

    public function set_send_delivery(Request $request){
        $table=\App\Orders::find($request->input('order_id'));
        $table->update([
            'delivery_status' => 'Sending',
            'delivery_send_date' => \Carbon\Carbon::now(),
        ]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => \App\Orders::find($request->input('order_id')),
            'type' => 'Update',
            'log' => 'Change Delivery Status "Send Delivery" Order. Changed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',$table->customer->name."'s order delivery status has changed as sending. Please be confirm it update delivered.");
    }

    public function set_not_send_delivery(Request $request){
        $table=\App\Orders::find($request->input('order_id'));
        $table->update([
            'delivery_status' => 'Not-delivered',
            'delivery_send_date' => null,
            'delivery_date' => null,
        ]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => \App\Orders::find($request->input('order_id')),
            'type' => 'Update',
            'log' => 'Change Delivery Status "Not Send Delivery" Order. Changed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',$table->customer->name."'s order delivery status has changed as not delivery.");
    }

    public function set_hold_delivery(Request $request){
        $table=\App\Orders::find($request->input('order_id'));
        $table->update([
            'delivery_status' => 'Hold',
            'delivery_send_date' => null,
            'delivery_date' => null,
        ]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => \App\Orders::find($request->input('order_id')),
            'type' => 'Update',
            'log' => 'Change Delivery Status "Hold Delivery" Order. Changed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',$table->customer->name."'s order delivery status has changed as hold.");
    }

    public function set_pending_delivery(Request $request){
        $table=\App\Orders::find($request->input('order_id'));
        $table->update([
            'delivery_status' => 'Pending',
            'delivery_send_date' => null,
            'delivery_date' => null,
        ]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => \App\Orders::find($request->input('order_id')),
            'type' => 'Update',
            'log' => 'Change Delivery Status "Pending Delivery" Order. Changed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',$table->customer->name."'s order delivery status has changed as pending.");
    }

    public function set_self_pickup_delivery(Request $request){
        $table=\App\Orders::find($request->input('order_id'));
        $table->update([
            'delivery_status' => 'Self-Pickup',
            'delivery_send_date' => null,
            'delivery_date' => \Carbon\Carbon::now(),
        ]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => \App\Orders::find($request->input('order_id')),
            'type' => 'Update',
            'log' => 'Change Delivery Status "Self Pickup Delivery" Order. Changed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',$table->customer->name."'s order delivery status has changed as pending.");
    }

    public function set_delivered_delivery(Request $request){
        $table=\App\Orders::find($request->input('order_id'));
        $table->update([
            'delivery_status' => 'Delivered',
            'delivery_date' => \Carbon\Carbon::now(),
        ]);
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Orders(),
            'property' => \App\Orders::find($request->input('order_id')),
            'type' => 'Update',
            'log' => 'Change Delivery Status "Delivered" Order. Changed By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',$table->customer->name."'s order delivery status has changed as delivered.");
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $table=\App\Orders::where('id',$id)->first();
        $table->delete();
        return redirect()->back()->with('success', "SSA/PO/".$table->track_id." - order has been removed.");
    }
}
