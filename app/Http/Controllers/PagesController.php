<?php

namespace App\Http\Controllers;

use App\Notifications\NewDonation;
use App\Notifications\NewVisit;
use App\Notifications\QuestionCompleted;
use App\Product_category;
use App\Product_reviews;
use App\Refund_points;
use App\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use VisitLog;
use App\Visit_logs;

class PagesController extends Controller
{
    public function index()
    {
        $current_ip_address = getenv('HTTP_CLIENT_IP')?: getenv('HTTP_X_FORWARDED_FOR')?: getenv('HTTP_X_FORWARDED')?: getenv('HTTP_FORWARDED_FOR')?: getenv('HTTP_FORWARDED')?: getenv('REMOTE_ADDR');
        $get_ips=Visit_logs::pluck('ip')->toArray();
        if(in_array($current_ip_address,$get_ips,true)){
            $get_ip=Visit_logs::where('ip',$current_ip_address)->first();
            $new_count=($get_ip->view_count +1);
            Visit_logs::where('ip', $current_ip_address)
                ->update([ 'view_count' => $new_count, 'updated_at' =>date('Y-m-d h:i:s'), ]);
        }
        else{
            VisitLog::save();//Fetch the Visitor logs information;
            $ip = $current_ip_address; $access_key = "22060952e8e7f1156e7330760d47bf7f";$lang=null;
            $get_time_zone = file_get_contents('https://ipapi.co/' . $ip . '/timezone/');
            $get_asn = file_get_contents('https://ipapi.co/' . $ip . '/asn/');
            $get_org = file_get_contents('https://ipapi.co/' . $ip . '/org/');
            $ch = curl_init('http://api.ipstack.com/' . $ip . '?access_key=' . $access_key . '');// Initialize CURL:
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($ch);// Store the data:
            curl_close($ch);
            $api_result = json_decode($json, true);// Decode JSON response:
            if(isset($api_result['location']['languages'])){
                $keys = array_keys($api_result['location']['languages']);
                for ($i = 0; $i < count($api_result['location']['languages']); $i++) {
                    $lang .= "Language #" . $keys[$i] . ":- ";
                    foreach ($api_result['location']['languages'][$keys[$i]] as $key => $value) {
                        $lang .= $key . ": " . $value . " - ";
                    }
                    $lang .= "<br/>";
                }
            }
            Visit_logs::where('ip', $ip)
                ->update([
                    'country_name' => isset($api_result['country_name'])? $api_result['country_name'] : '-',
                    'country_code' => isset($api_result['country_code'])? $api_result['country_code'] : '-',
                    'region_name' => isset($api_result['region_name'])? $api_result['region_name'] : '-',
                    'city' => isset($api_result['city'])? $api_result['city'] : '-',
                    'zip_code' => isset($api_result['zip'])? $api_result['zip'] : '-',
                    'latitude' => isset($api_result['latitude'])? $api_result['latitude'] : '-',
                    'longitude' => isset($api_result['longitude'])? $api_result['longitude'] : '-',
                    'time_zone' => $get_time_zone,
                    'geoname_id' => isset($api_result['location']['geoname_id'])? $api_result['location']['geoname_id'] : '-',
                    'capital' => isset($api_result['location']['capital'])? $api_result['location']['capital'] : '-',
                    'country_flag' => isset($api_result['location']['country_flag'])? $api_result['location']['country_flag'] : '-',
                    'connection_asn' => $get_asn, 'connection_isp' => $get_org, 'languages' => $lang,'view_count' => '1',
                ]);

            $table=\App\Visit_logs::where('ip',$ip)->first();
            \App\Visit_logs::where('ip',$ip)->first()->notify(new NewVisit($table));

        }
        return view('pages.index');
    }

    public function employee_register($id, $name)
    {
        return view('auth.employee_register');
    }

    public function employee_register_with_login($id, $name)
    {
        return view('auth.employee_register');
    }

    public function products()
    {
        if(!isset($_COOKIE['load_popup'])) {
            setcookie('load_popup', 'true', time() + (86400 * 30), '/');
        }

        return view('pages.products.index', [
            'products' => \App\Products::where('status', 'PUBLISHED')->where('visibility', 1)->orderby('created_at', 'DESC')->paginate(20)
        ]);
    }

    public function view_product($slug)
    {
        return view('pages.products.product_detail', [
            'data' => \App\Products::where('slug', $slug)->firstOrFail(),
            'fb_customs_product_info'=>true,
        ]);
    }

    public function product_quick_view(request $request)
    {
        if ($request->ajax()) {
            return view('pages.products.products_quick_view', [
                'data' => \App\Products::WHERE('id', $request->id)->firstOrFail(),
            ])->render();
        } else {
            return redirect()->back();
        }
    }

    public function store_review(Request $request)
    {
        $this->validate($request, [
            'rate' => 'required| max:5',
            'comments' => 'required',
            'name' => 'required',
        ]);

        $order_ids=\App\Orders::where('user_id',\auth::user()->id)->where('status','Confirmed')->where('delivery_status','Delivered')->pluck('id')->toArray();
        $order_pic_ids=\App\Orders::where('user_id',\auth::user()->id)->where('status','Confirmed')->where('delivery_status','Self-Pickup')->pluck('id')->toArray();
        $countOforders =\App\Order_items::whereIn('order_id',array_merge($order_ids,$order_pic_ids))->where('product_id',$request->input('product_id'))->get()->count();
        $countOfReviews =\App\Product_reviews::where('user_id', $request->input('user_id'))->whereNull('is_deleted')->where('product_id', $request->input('product_id'))->get()->count();
        if($countOforders > $countOfReviews){
            \App\Product_reviews::create($request->all());
            return redirect()->back()->with('success', 'Thank you for your valuable review.');
        }else{
            return redirect()->back()->with('error', 'Looks like you already reviewed this product for your orders!');
        }
    }

    public function load_more_review(Request $request)
    {
        $data = \App\Products::find($request->product_id);
        $rows = $request->get('row_count');
        return view('components.products.product_review_data', [
            'product_reviews' => \App\Product_reviews::orderby('created_at', 'desc')->where('product_id', $request->product_id)->limit($rows)->get(),
            'get_rev_count' => $data->reviews->count(),
            'product_id' => $data->id,
        ])->render();
    }

    public function remove_review(Request $request)
    {
        \App\Product_reviews::where('user_id', $request->user_id)->where('product_id', $request->product_id)->delete();
        return redirect()->back()->with('success', \App\Products::where('id', $request->product_id)->firstOrFail()->name . '\s product review has been cleared.');
    }

    public function category_level_check($id)
    {

        $level = 1;
        $data = \App\Product_category::find(HashDecode($id));
        if (isset($data->id)) {
            $level = 1;
        }
        if (isset($data->parent->id)) {
            $level = 2;
        }
        if (isset($data->parent->parent->id)) {
            $level = 3;
        }
        if ($level == 1) {
            return redirect()->route('products.category.level_one', $id);
        } elseif ($level == 2) {
            return redirect()->route('products.category.level_two', [HashEncode($data->parent->id), $id]);
        } elseif ($level == 3) {
            return redirect()->route('products.category.level_three', [HashEncode($data->parent->parent->id), HashEncode($data->parent->id), $id]);
        }
    }

    public function product_category_level_one($id)
    {
        $second_category_Ids = \App\Product_category::where('parent_id', $parentId = \App\Product_category::where('id', HashDecode($id))
            ->value('id'))
            ->pluck('id')
            ->push($parentId)
            ->all();
        $third_category_Ids = $second_category_Ids = \App\Product_category::whereIn('parent_id', $second_category_Ids)
            ->pluck('id')
            ->push($parentId)
            ->all();

//        Test_result
//        foreach ($third_category_Ids as $k=>$val){
//            echo \App\Product_category::find($val)->name."<br/>";
//        }

        return view('pages.products.index', [
            'products' => \App\Products::where('status', 'PUBLISHED')->where('visibility', 1)->whereIn('category_id', $third_category_Ids)->orderby('created_at', 'DESC')->paginate(20),
            'second_categories' => \App\Product_category::with('children')
                ->with('category_products')
                ->where('parent_id', HashDecode($id))
                ->orderBy('name', 'asc')
                ->get(),
            'first_lvl_category_detail' => \App\Product_category::find(HashDecode($id)),
        ]);
    }

    public function product_category_level_two($id, $lvl_2_id)
    {

        $category_ids = $second_category_Ids = \App\Product_category::where('parent_id', HashDecode($lvl_2_id))
            ->pluck('id')->toArray();
        return view('pages.products.index', [
            'products' => \App\Products::where('status', 'PUBLISHED')->where('visibility', 1)->whereIn('category_id', $category_ids)->orderby('created_at', 'DESC')->paginate(20),
            'second_categories' => \App\Product_category::with('children')
                ->where('parent_id', HashDecode($id))
                ->orderBy('name', 'asc')
                ->get(),
            'third_categories' => \App\Product_category::where('parent_id', HashDecode($lvl_2_id))->get(),
            'first_lvl_category_detail' => \App\Product_category::find(HashDecode($id)),
            'second_lvl_category_detail' => \App\Product_category::find(HashDecode($lvl_2_id)),
        ]);
    }

    public function product_category_level_three($id, $lvl_2_id, $lvl_3_id)
    {

        return view('pages.products.index', [
            'products' => \App\Products::where('status', 'PUBLISHED')->where('visibility', 1)->where('category_id', HashDecode($lvl_3_id))->orderby('created_at', 'DESC')->paginate(20),
            'second_categories' => \App\Product_category::with('children')
                ->with('category_products')
                ->where('parent_id', HashDecode($id))
                ->orderBy('name', 'asc')
                ->get(),
            'third_categories' => \App\Product_category::where('parent_id', HashDecode($lvl_2_id))->get(),
            'first_lvl_category_detail' => \App\Product_category::find(HashDecode($id)),
            'second_lvl_category_detail' => \App\Product_category::find(HashDecode($lvl_2_id)),
            'three_lvl_category_detail' => \App\Product_category::find(HashDecode($lvl_3_id)),
        ]);
    }

    //:ajax fetch
    public function fetch_third_level_categories(Request $request)
    {
        if ($request->ajax()) {
            return view('components.products.fetch_third_level_categories', [
                'third_categories' => \App\Product_category::whereIn('parent_id', $request->ids)->get(),
            ])->render();
        }
    }

    public function fetch_product_filter_data(request $request)
    {
        $products = "";
        $is_wish_list_available = false;
        if ($request->ajax()) {

            //:: Main Query
            $product_info = \App\Products::whereNull('is_deleted')->where('status', 'PUBLISHED')->where('visibility', 1);
            if ($request->first_lvl_tag && !empty($request->first_lvl_tag)) {
                $second_category_Ids = \App\Product_category::where('parent_id', $parentId = \App\Product_category::where('id', $request->first_lvl_tag)
                    ->value('id'))
                    ->pluck('id')
                    ->push($parentId)
                    ->all();
                $third_category_Ids = $second_category_Ids = \App\Product_category::whereIn('parent_id', $second_category_Ids)
                    ->pluck('id')
                    ->push($parentId)
                    ->all();
                $product_info->whereIn('category_id', $third_category_Ids);
            }

            if ($request->second_lvl_tag && !empty($request->second_lvl_tag)) {
                $category_filters = explode(',', $request->second_lvl_tag);
                $sub_ids = $second_category_Ids = \App\Product_category::whereIn('parent_id', $category_filters)
                    ->pluck('id')->toArray();
                $product_info->whereIn('category_id', array_merge($sub_ids, $category_filters));
            }

            if ($request->third_lvl_tag && !empty($request->third_lvl_tag)) {
                $category_filter_ids = explode(',', $request->third_lvl_tag);
                $product_info->whereIn('category_id', $category_filter_ids);
            }

            if ($request->stock && !empty($request->stock)) {
                if ($request->stock == 'yes') {
                    $product_info->where('stock', '>', 0);
                }
            }

            if ($request->minimum_price || $request->maximum_price && !empty($request->minimum_price) && !empty($request->maximum_price)) {
                //$product_info->where('price','>=',$request->minimum_price)->where('price','<=',$request->maximum_price);
                $product_info->whereBetween('price', array($request->minimum_price, $request->maximum_price));
                //$product_info->orWhere('is_negotiable',1);
            }

            if ($request->wish_list_check && $request->wish_list_check == 1) {
                $product_info->whereIn('id', \App\Wishlist::where('user_id', \Auth::user()->id)->pluck('product_id')->toArray());
                $is_wish_list_available = true;
            }

            if ($request->sorting && !empty($request->sorting)) {
                if ($request->sorting == "New") {
                    $product_info->orderby('created_at', 'DESC');
                } elseif ($request->sorting == "Old") {
                    $product_info->orderby('created_at', 'ASC');
                } elseif ($request->sorting == "Low_to_high") {
                    $product_info->orderby('price', 'ASC');
                } elseif ($request->sorting == "High_to_low") {
                    $product_info->orderby('price', 'DESC');
                }
            }

            if ($request->show_item && !empty($request->show_item) && $request->show_item != "NaN") {
                $products = $product_info->orderby('created_at', 'desc')->paginate($request->show_item);
            } else {
                $products = $product_info->orderby('created_at', 'desc')->paginate(15);
            }

            $product_view = view('components.products.products_data_fetch', [
                'products' => $products,
                'is_wish_list_available' => $is_wish_list_available,
            ])->render();

            return response()->json([
                'view' => $product_view,
            ]);
        }
    }

    public function pop_up_curd(Request $request){

        setcookie('load_popup', $request->status, time() + (86400 * 30), '/');
        return response()->json($request->status);
    }

    public function prakrti_interview(){
        $table_answer_ids=\App\Customers_answers::where('user_id',\auth::user()->id)->whereNull('is_deleted')->first();
        if(!$table_answer_ids || \Session::get('data_submitted')) {
            return view('pages.prakrti_interview', ['answers' => $table_answer_ids]);
        }else{
            return redirect()->route('prakrti.products');
        }
    }

    public function re_check_interview(){
        \App\Customers_answers::where('user_id',\auth::user()->id)->update(['is_deleted' => \Carbon\Carbon::now()]);
        $table_answer_ids=\App\Customers_answers::where('user_id',\auth::user()->id)->whereNull('is_deleted')->first();
        if(!$table_answer_ids) {
            return redirect()->route('prakrti.interview');
        }else{
            return redirect()->route('prakrti.products');
        }
    }

    public function prakrti_products(){
        $table_answer_ids=\App\Customers_answers::where('user_id',\auth::user()->id)->whereNull('is_deleted')->first();
        if($table_answer_ids){
            $count_array=array($table_answer_ids->vata,$table_answer_ids->pitta,$table_answer_ids->kapha);
            $test_array=array(['name' => 'vata','count' => $table_answer_ids->vata],['name' => 'pitta','count' => $table_answer_ids->pitta],['name' => 'kapha','count' => $table_answer_ids->kapha]);
            //:Check scored high category
            $types=array(); foreach($test_array as $val){ if(max($count_array) <= $val['count'] || min($count_array) < $val['count']){ array_push($types,$val['name']); } }

            //:Filter user's answer id by high scored
            $user_answer_ids=explode(',', $table_answer_ids->answer_ids);
            $answers=array(); foreach ($user_answer_ids as $value){ if(in_array(strtolower(\App\Answers::find($value)->type),$types,true)){ array_push($answers,$value); } }


            $product_ids = \App\Product_Questions_Answers::whereIn('answer_id',$answers)->pluck('product_id')->toArray();
            $service_ids = \App\Service_questions_answers::whereIn('answer_id',$answers)->pluck('service_id')->toArray();
            return view('pages.products.prakrti_products',[
                'products' => \App\Products::whereIn('id',$product_ids)->where('stock','>',0)->where('status', 'PUBLISHED')->where('visibility', 1)->orderby('created_at', 'DESC')->paginate(9),
                'services' => \App\Service::whereIn('id',$service_ids)->where('visibility', 1)->orderby('created_at', 'DESC')->paginate(6)
            ]);
        }else{
            return redirect()->route('prakrti.interview');
        }
    }

    public function prakrti_services(){
        $table_answer_ids=\App\Customers_answers::where('user_id',\auth::user()->id)->whereNull('is_deleted')->first();

        if($table_answer_ids){
            $count_array=array($table_answer_ids->vata,$table_answer_ids->pitta,$table_answer_ids->kapha);
            $test_array=array(['name' => 'vata','count' => $table_answer_ids->vata],['name' => 'pitta','count' => $table_answer_ids->pitta],['name' => 'kapha','count' => $table_answer_ids->kapha]);
            //:Check scored high category
            $types=array(); foreach($test_array as $val){ if(max($count_array) <= $val['count'] || min($count_array) < $val['count']){ array_push($types,$val['name']); } }

            //:Filter user's answer id by high scored
            $user_answer_ids=explode(',', $table_answer_ids->answer_ids);
            $answers=array(); foreach ($user_answer_ids as $value){ if(in_array(strtolower(\App\Answers::find($value)->type),$types,true)){ array_push($answers,$value); } }

            $product_ids = \App\Product_Questions_Answers::whereIn('answer_id',$answers)->pluck('product_id')->toArray();
            $service_ids = \App\Service_questions_answers::whereIn('answer_id',$answers)->pluck('service_id')->toArray();
            return view('pages.services.prakrti_services',[
                'services' => \App\Service::whereIn('id',$service_ids)->where('visibility', 1)->orderby('created_at', 'DESC')->paginate(9),
                'products' => \App\Products::whereIn('id',$product_ids)->where('status', 'PUBLISHED')->where('visibility', 1)->orderby('created_at', 'DESC')->paginate(6),
            ]);
        }else{
            return redirect()->route('prakrti.interview');
        }
    }

    public function store_interview_answers(Request $request){
        //\App\User::where('id',\auth::user()->id)->update(['gender' => $request->input('user_gender')]);
        $table=\App\Customers_answers::create($request->all());
        \App\Customers_answers::find($table->id)->notify(new QuestionCompleted($table));
        return redirect()->back()->with('data_submitted','success');
    }

    public function send_answerd_copy(){
        $table_answer=\App\Customers_answers::where('user_id',\auth::user()->id)->whereNull('is_deleted')->first()->toArray();
        $user_email=\auth::user()->email;
        \Mail::send('emails.customer_answer_copy',['table_answer'=>$table_answer], function($message) use ($table_answer,$user_email){
            $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
            $message->to($user_email);
            $message->subject('Prakrti Par朝ksha Answer Copy from '.\config('app.name'));
        });
        //:: Email View test
        //return view('emails.customer_answer_copy',['table_answer' => $table_answer]);
        return response()->json('success');
    }

    public function search_product(Request $request)
    {
        $terms = explode(' ', $request->input('keyword'));
        $data_products = \App\Products::where('stock','>',0)->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orwhere('name', 'LIKE', '%' . $term . '%');
                    $query->orwhere('description', 'LIKE', '%' . $term . '%');
                }
            })
            ->WhereNull('is_deleted')
            ->where('status', 'PUBLISHED')->orderby('name', 'asc')->paginate(20);

        $data_services = \App\Service::where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orwhere('name', 'LIKE', '%' . $term . '%');
                    $query->orwhere('description', 'LIKE', '%' . $term . '%');
                }
            })
            ->WhereNull('is_deleted')
            ->where('status', 'Available')->orderby('name', 'asc')->paginate(20);
        return view('pages.search_page',[
            'data_products' => $data_products,
            'data_services' => $data_services,
            'old_search_word' => $request->input('keyword'),
        ]);
    }

    public function services()
    {
        return view('pages.services.index', [
            'services' => \App\Service::WhereNull('is_deleted')->where('visibility', 1)->orderby('created_at', 'DESC')->paginate(20)
        ]);
    }

    public function fetch_service_filter_data(request $request)
    {
        $services = "";
        if ($request->ajax()) {
            //:: Main Query
            $service_info = \App\Service::whereNull('is_deleted')->where('visibility', 1);
            if ($request->first_lvl_tag && !empty($request->first_lvl_tag)) {
                $service_info->where('category_id', $request->first_lvl_tag);
            }

            if ($request->available && !empty($request->available)) {
                if ($request->available == 'yes') {
                    $service_info->where('status', 'Available');
                }
            }

            if ($request->minimum_price || $request->maximum_price && !empty($request->minimum_price) && !empty($request->maximum_price)) {
                $service_info->whereBetween('price', array($request->minimum_price, $request->maximum_price));
            }

            if ($request->sorting && !empty($request->sorting)) {
                if ($request->sorting == "New") {
                    $service_info->orderby('created_at', 'DESC');
                } elseif ($request->sorting == "Old") {
                    $service_info->orderby('created_at', 'ASC');
                } elseif ($request->sorting == "Low_to_high") {
                    $service_info->orderby('price', 'ASC');
                } elseif ($request->sorting == "High_to_low") {
                    $service_info->orderby('price', 'DESC');
                }
            }

            if ($request->show_item && !empty($request->show_item) && $request->show_item != "NaN") {
                $services = $service_info->orderby('created_at', 'desc')->paginate($request->show_item);
            } else {
                $services = $service_info->orderby('created_at', 'desc')->paginate(15);
            }

            return response()->json([
                'view' => view('components.services.service_data_fetch', [
                    'services' => $services,
                ])->render(),
            ]);
        }
    }

    public function service_category($slug)
    {
        return view('pages.services.category_view', [
            'data' => \App\Service_category::where('slug', $slug)->first(),
        ]);

//        return view('pages.services.index', [
//            //'data' => \App\Service_category::where('slug', $slug)->first(),
//            'services' => \App\Service::WhereNull('is_deleted')->where('category_id',\App\Service_category::where('slug', $slug)->first()->id)->where('visibility', 1)->orderby('created_at', 'DESC')->paginate(20),
//            'first_lvl_category_detail' => \App\Service_category::find(\App\Service_category::where('slug', $slug)->first()->id),
//        ]);
    }

    public function services_details($category_slug, $service_slug)
    {
        return view('pages.services.view', [
            'data' => \App\Service::where('slug', $service_slug)->firstOrfail(),
            'fb_customs_service_info' =>true,
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function careers()
    {
        return view('pages.careers');
    }

    public function terms_and_condition()
    {
        return view('pages.terms_and_conditions');
    }

    public function privacy_policy()
    {
        return view('pages.privacy_policy');
    }

    public function affiliate_policy()
    {
        return view('pages.affiliate_policy');
    }

    public function transaction_policy()
    {
        return view('pages.transaction_policy');
    }

    public function voucher_code($code){
        return view('pages.voucher.index',['data' => \App\Vouchers::find(HashDecode($code))]);
    }

    public function check_partner_code(Request $request){
        $status='failed';
        if($request->ajax()){
            $table_user_code = \App\User::where('user_code',$request->input('code'))->WhereNotNull('agent_id')->first();
            $table_user_email = \App\User::where('email',$request->input('code'))->WhereNotNull('agent_id')->first();
            $table_user_name = \App\User::where('user_name',$request->input('code'))->WhereNotNull('agent_id')->first();
            $table_coupon_name = \App\UserCouponCode::where('code',$request->input('code'))->WhereNull('is_deleted')->first();
            if($table_user_code){
                $status = 'valid';
                return response()->json(['status'=>$status,'user_id' => $table_user_code->id, 'partner_id' => $table_user_code->employee->id,'partner_name' =>$table_user_code->name." ".$table_user_code->last_name ]);
            }elseif($table_user_email){
                $status = 'valid';
                return response()->json(['status'=>$status,'user_id' => $table_user_email->id, 'partner_id' => $table_user_email->employee->id,'partner_name' =>$table_user_email->name." ".$table_user_email->last_name]);
            }elseif($table_user_name){
                $status = 'valid';
                return response()->json(['status'=>$status,'user_id' => $table_user_name->id,  'partner_id' => $table_user_name->employee->id,'partner_name' =>$table_user_name->name." ".$table_user_name->last_name]);
            }elseif($table_coupon_name){
                $status = 'valid';
                return response()->json(['status'=>$status,'user_id' => $table_coupon_name->user->id,  'partner_id' => $table_coupon_name->user->employee->id,'partner_name' =>$table_coupon_name->user->name." ".$table_coupon_name->user->last_name]);
            }else{
                return response()->json(['status'=>$status]);
            }
        }else{
            return response()->json(['status'=>'failed']);
        }
    }

    public function check_user_code(Request $request){
        $status='failed';
        if($request->ajax()){
            $table_user_code = \App\User::where('user_code',$request->code)->first();
            $table_user_email = \App\User::where('email',$request->code)->first();
            $table_user_name = \App\User::where('user_name',$request->code)->first();
            $table_coupon_name = \App\UserCouponCode::where('code',$request->code)->WhereNull('is_deleted')->first();
            if($table_user_code){
                $status = 'valid';
                return response()->json(['status'=>$status,'user_id' => $table_user_code->id, 'partner_id' => ($table_user_code->employee)? $table_user_code->employee->id : null,'partner_name' =>$table_user_code->name." ".$table_user_code->last_name ]);
            }elseif($table_user_email){
                $status = 'valid';
                return response()->json(['status'=>$status,'user_id' => $table_user_email->id, 'partner_id' => ($table_user_email->employee)? $table_user_email->employee->id : null,'partner_name' =>$table_user_email->name." ".$table_user_email->last_name]);
            }elseif($table_user_name){
                $status = 'valid';
                return response()->json(['status'=>$status,'user_id' => $table_user_name->id,  'partner_id' => ($table_user_name->employee)? $table_user_name->employee->id : null,'partner_name' =>$table_user_name->name." ".$table_user_name->last_name]);
            }elseif($table_coupon_name){
                $status = 'valid';
                return response()->json(['status'=>$status,'user_id' => $table_coupon_name->user->id,  'partner_id' => ($table_coupon_name->employee)? $table_coupon_name->employee->id : null,'partner_name' =>$table_coupon_name->user->name." ".$table_coupon_name->user->last_name]);
            }else{
                return response()->json(['status'=>$status]);
            }
        }else{
            return response()->json(['status'=>'failed']);
        }
    }

    public function contact_submit(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $from_mail= $request->input('email');
        \Mail::send('emails.contact', ['data' => $request->all()], function($message) use ($from_mail){
            $message->from($from_mail, env('APP_NAME'));
            $message->to(\App\Details::where('key','company_email')->first()->value);
            $message->subject(env('APP_NAME').' Contact Message');
        });
        return redirect()->back()->with('success',$request->input('name').'! You inquiries has been send.');
    }
//    public function check_partner_code(Request $request){
//        $status='failed';
//        if($request->ajax()){
//            $table_user_code = User::where('user_code',$request->input('code'))->WhereNull('is_deleted')->WhereNotNull('agent_id')->first();
//            $table_user_email = User::where('email',$request->input('code'))->WhereNull('is_deleted')->WhereNotNull('agent_id')->first();
//            $table_user_name = User::where('user_name',$request->input('code'))->WhereNull('is_deleted')->WhereNotNull('agent_id')->first();
//            if($table_user_code){
//                $status = 'valid';
//                return response()->json(['status'=>$status,'partner_id' => $table_user_code->employee->id,'partner_name' =>$table_user_code->name." ".$table_user_code->last_name ]);
//            }elseif($table_user_email){
//                $status = 'valid';
//                return response()->json(['status'=>$status,'partner_id' => $table_user_email->employee->id,'partner_name' =>$table_user_email->name." ".$table_user_email->last_name]);
//            }elseif($table_user_name){
//                $status = 'valid';
//                return response()->json(['status'=>$status,'partner_id' => $table_user_name->employee->id,'partner_name' =>$table_user_name->name." ".$table_user_name->last_name]);
//            }else{
//                return response()->json(['status'=>$status]);
//            }
//        }else{
//            return response()->json(['status'=>'failed']);
//        }
//    }
}
