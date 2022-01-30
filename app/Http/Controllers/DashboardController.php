<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user_dashboard.index');
    }

    public function orders()
    {
        return view('user_dashboard.orders.index');
    }

    public function orders_details($id)
    {
        return view('user_dashboard.orders.view',[
            'data' => \App\Orders::where('id',HashDecode($id))->where('user_id',\auth::user()->id)->first(),
        ]);
    }

    function get_coming_up_bookings(){
        $dates=\App\Service_booking::where('status','Pending')->Orwhere('status','Confirmed')->get();
        $data_events = array();
        $get_color=null; $text_color=null;
        foreach($dates as $row){
            $data_events[] = array(
                "id" => $row->id,
                "date" => $row->book_date,
                "calendar" => 'book',
                "title" => "Booked",
                "color" => "#f7f8d9",
                "background" => "#121212"
            );
        }
        return response()->json($data_events);
        exit();
    }

    public function send_order_cancel_request(Request $request)
    {
        $table=\App\Orders::where('id',$request->input('order_id'))->where('user_id',\auth::user()->id)->first();
        if($table->status !="Canceled"){
            $table->update([
                'status' => 'Canceled',
                'delivery_status' => 'Not-delivered',
                'canceled_date' => \Carbon\Carbon::now(),
                'cancel_reason' => $request->input('cancel_reason')
            ]);
            $refund_points=null;
            if($table->payment->paid_points){
                $refund_points=$table->payment->paid_points;
            }else{
                $refund_points = ($table->payment->paid_amount*(\App\Details::where('key','points_rate')->first()->amount));
            }

            //: increase the stock from reject order item
            foreach ($table->items as $item){
                $table_product=\App\Products::where('id',$item->product_id)->first();
                $table_product->update([
                    'stock' => ($table_product->stock + $item->qty)
                ]);
            }

            \App\Refund_points::create([
                'user_id'=>\auth::user()->id,
                'order_id' => $table->id,
                'refund_points' => $refund_points,
            ]);
            return redirect()->back()->with('success',"SSA/PO/".$table->track_id." Order has been canceled and refund your payment as points.");
        }else{
            return redirect()->back()->with('success',"SSA/PO/".$table->track_id." Order has been already canceled and refunded your payment as points.");
        }

    }

    public function send_order_hold_request(Request $request)
    {
        $table=\App\Orders::find($request->input('order_id'));
        $table->update(['delivery_status' => 'Hold']);

        return redirect()->back()->with('success',"SSA/PO/".$table->track_id." Order has been hold, until you confirmation.");
    }

    public function wishList()
    {
        return view('user_dashboard.wishlist');
    }

    public function address()
    {
        return view('user_dashboard.address');
    }

    public function transaction(){
        return view('user_dashboard.transaction');
    }

    public function account()
    {
        return view('user_dashboard.account_setting');
    }

    public function Password()
    {
        return view('profile.updatePassword');
    }

    public function update_user_info(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'city' => 'required',
        ]);

        $subscribe_status =0;
        if(!empty($request->e_subscribe)){ $subscribe_status = 1; }

        \App\User::where('id', \Auth::user()->id)
            ->update([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'contact' => $request->contact,
                'gender' => $request->gender,
                'country' => $request->country,
                'city' => $request->city,
                'e_subscribe' => $subscribe_status,
            ]);

        if ($request->hasFile('profile_image')) {
            try {
                $image = $request->file('profile_image');
                $input['profile_image'] = "user_img_".\Auth::user()->id."-".time().'.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/profile_image');
                $image->move($destinationPath, $input['profile_image']);
                $destinationPath="uploads/profile_image/";
                \App\User::where('id', \Auth::user()->id)
                    ->update([
                        'profile_image' => $destinationPath.$input['profile_image'],
                    ]);
            } catch (exception $e) { }
        }
        return redirect()->back()->with('success', $request->name. '! Your details has been successfully updated!');
    }

    public function update_user_pwd(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'string|confirmed|min:8|different:old_password',
        ]);
        $user = \App\User::findOrFail(\Auth::user()->id);
        if (!Hash::check($request['old_password'], \Auth::user()->password)) {
            return redirect()->back()->with('old_password_error', 'The old password does not match our records.');
        }else{
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return redirect()->back()->with('success', $user->name. '! Your password has been successfully updated!');
        }
    }

    public function add_coupon_codes(Request $request)
    {
        $request->validate([
            'code' =>  ['required',
                Rule::unique('user_coupon_codes')
                    ->where('code', $request->input('code'))
            ],
        ]);

        if(\auth::user()->coupon_codes->count() < 3){
            \App\UserCouponCode::create($request->all());
            return redirect()->back()->with('success',$request->input('code').' Code has been Added.');
        }else{
            return redirect()->back()->with('error','Sorry, You can\'t create more than three coupon codes.');
        }
    }

    public function get_sub_categories(Request $request)
    {
        $output = "<option selected disabled value='null' class='text-gray'>Which category?</option>";
        $get_sub_cat_ids = P_category::where('parent_id', $request->category_id)->pluck('id');
        $get_sub_info = P_category::WhereIn('id', $get_sub_cat_ids)->orderby('name', 'asc')->get();
        if (count($get_sub_info) > 0) {
            foreach ($get_sub_info as $k => $cat) {
                $output .= "<option value='" . $cat->id . "'>" . $cat->name . "</option>";
            }
        } else {
            $output = "<option selected value='null' disabled>No Result Found</option>";
        }
        return response()->json($output);
    }

    public function get_last_categories(Request $request)
    {
        $output = "<option selected disabled value='null' class='text-gray'>Which suggestion category?</option>";
        $get_sub_cat_ids = P_category::where('parent_id', $request->category_id)->pluck('id');
        $get_sub_info = P_category::WhereIn('id', $get_sub_cat_ids)->orderby('name', 'asc')->get();
        if (count($get_sub_info) > 0) {
            foreach ($get_sub_info as $k => $cat) {
                $output .= "<option value='" . $cat->id . "'>" . $cat->name . "</option>";
            }
        } else {
            $output = "<option selected value='null' disabled>No Result Found</option>";
        }
        return response()->json($output);
    }

    public function add_payment_info(Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'bank_branch' => 'required',
            'bank_number' => 'required',
            'bank_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            //:image_1_upload
            $image = $request->file('bank_image');
            $input['bank_image'] = rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/bank_evidence');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777);
            }

            $destinationPath = public_path('uploads/bank_evidence/thumbnail');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777);
            }
            $img = Image::make($image->path());
            $img->resize(540, 600, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath . '/' . $input['bank_image']);
            $destinationPath = public_path('/uploads/bank_evidence');
            $image->move($destinationPath, $input['bank_image']);

            $info = new Seller_payment_info;
            $info->user_id = Auth::user()->id;
            $info->bank_name = $request->input('bank_name');
            $info->bank_branch = $request->input('bank_branch');
            $info->bank_ac_number = $request->input('bank_number');
            $info->bank_evidence = $input['bank_image'];
            $info->suggestion = $request->input('suggestion_text');
            $info->save();

        } catch (exception $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Your account details has been successfully added with us.');
    }

    public function edit_payment_info(Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'bank_branch' => 'required',
            'bank_number' => 'required',
            'bank_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {

            if ($request->hasFile('bank_image')) {
                $image = $request->file('bank_image');
                $input['bank_image'] = rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/bank_evidence');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $destinationPath = public_path('uploads/bank_evidence/thumbnail');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $img = Image::make($image->path());
                $img->resize(540, 600, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $input['bank_image']);
                $destinationPath = public_path('/uploads/bank_evidence');
                $image->move($destinationPath, $input['bank_image']);
            }

            $info = Seller_payment_info::where('user_id', Auth::user()->id)->first();
            $info->bank_name = $request->input('bank_name');
            $info->bank_branch = $request->input('bank_branch');
            $info->bank_ac_number = $request->input('bank_number');
            if ($request->hasFile('bank_image')) {
                $info->bank_evidence = $input['bank_image'];
            }
            $info->suggestion = $request->input('suggestion_text');
            $info->save();

        } catch (exception $e) {

            return redirect()->back()->with('errors', $e->getMessage());
        }
        return redirect()->back()->with('success', 'Your account details has been successfully updated.');
    }

    public function reservations(){
        return view('user_dashboard.reservations');
    }

    public function show_reservations($id){
        return view('user_dashboard.reservation_details',[
            'data' => \App\Service_booking::where('id',HashDecode($id))->where('user_id',\auth::user()->id)->first(),
        ]);
    }

    public function cancel_reservations($id){
        $data=\App\Service_booking::find($id);
        if($data->status != "Canceled"){
            $data->update([
                'status' => 'Canceled',
                'canceled_date' => \Carbon\Carbon::now()
            ]);

            $refund_points=null;
            if($data->paid_points){
                $refund_points=getPointsFormat($data->paid_points);
            }else{
                $refund_points = getPointsFormat(($data->paid_amount/(\App\Details::where('key','points_rate')->firstOrFail()->amount)));
            }
            \App\Refund_points::create([
                'user_id'=>\Auth::user()->id,
                'booking_id' => $id,
                'refund_points' => $refund_points,
            ]);

            return redirect()->back()->with('success',$data->service->name." - service reservations been cancelled and, Refunded your your payment as Points... Thanks for your reservation.");
        }else{
            return redirect()->back()->with('success',$data->service->name." - service reservations been already cancelled and, Refunded your your payment as Points...");
        }
    }
    public function fetch_city(Request $request){
        $data = "<option value='null' disabled selected>Choose the city</option>";
        if($request->ajax()) {
            foreach (\App\Location::where('parent_id', $request->id)->orderby('name', 'asc')->get() as $row) {
                $data .= "<option value='" . $row->name . "'>" . $row->name . "</option>";
            }
        }
        return response()->json($data);
    }
}
