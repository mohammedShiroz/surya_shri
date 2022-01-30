<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Validation\Rule;
use App\Observers\ActivityLogObserver;

class ProductController extends Controller
{

    public function __construct()
    {
        \App\Products::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        if(\auth::user()->haspermission('read-products')) {
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Products(),
                'property' => ['name' => 'Check Products List'],
                'type' => 'Read',
                'log' => 'Check Products List Read By ' . \Auth::user()->name,
            ]));
            return view('backend.products.index');
        }
        abort(403);
    }

    public function create()
    {
        return view('backend.products.create');
    }

    public function fetch_category_two(Request $request){
        $data = "<option value='null' disabled selected>Select Item Category</option>";
        if($request->ajax()) {
            foreach (\App\Product_category::where('parent_id', $request->id)->orderby('name', 'asc')->get() as $row) {
                $data .= "<option value='" . $row->id . "'>" . $row->name . "</option>";
            }
        }
        return response()->json($data);
    }

    public function fetch_category_three(Request $request){
        $data = "<option value='null' disabled selected>Select Item Sub Category</option>";
        if($request->ajax()) {
            foreach (\App\Product_category::where('parent_id', $request->id)->orderby('name', 'asc')->get() as $row) {
                $data .= "<option value='" . $row->id . "'>" . $row->name . "</option>";
            }
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $messages = [
            'product_type.required' => 'The product category field is required.',
            'name.required' => 'The product name field is required.',
            'name.unique' => 'The product name has been already assigned.',
            'stock.required' => 'The product stock field is required.',
            'order.unique' => 'The sequence has already been assigned.',
            'item_code.unique' => 'The product code has already been assigned.'
        ];

        $this->validate($request, [
            'product_type' => 'required',
            'name' =>  ['required',
                Rule::unique('products')
                    ->where('name', $request->input('name'))
            ],
            'price' => 'required',
            'actual_price' => 'required',
            'seller_paid' => 'required',
            'seller_id' => 'required',
            'stock' => 'required',
            'item_code' =>  [
                Rule::unique('products')
                    ->where('item_code', $request->input('item_code'))
            ],
            'order' => ['nullable', Rule::unique('products')
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $category_id=null; $is_negotiable=0; $is_deliverable=0; $status=0;
        if(!is_null($request->is_negotiable_val)){ $is_negotiable = 1; }
        if(!is_null($request->is_deliverable_val)){ $is_deliverable = 1; }
        if(!is_null($request->visibility_status)){ $status = 1; }

        if($request->product_type){ $category_id = $request->product_type; }
        if(($request->product_type && !empty($request->product_type)) && ($request->item_category && !empty($request->item_category))){
            $category_id = $request->item_category;
        }
        if(($request->product_type && !empty($request->product_type)) && ($request->item_category && !empty($request->item_category)) && ($request->item_sub_category && !empty($request->item_sub_category))){
            $category_id = $request->item_sub_category;
        }
        $table=\App\Products::create($request->all());
        $table->slug = make_slug($request->input('name'));
        $table->category_id = $category_id;
        $table->is_negotiable = $is_negotiable;
        $table->is_deliverable = $is_deliverable;
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $input['image'] = "pro_img_".rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/products_images/thumbnail');
                if (!file_exists($destinationPath)) { mkdir($destinationPath, 0777); }
                $img1 = Image::make($image->path());
                $img1->resize(540, 550);
                $img1->save($destinationPath . '/' . $input['image']);
                $destinationPath = public_path('/uploads/products_images');
                $image->move($destinationPath, $input['image']);
                $destinationPath="uploads/products_images/";
                $table->image = $destinationPath.$input['image'];
                $destinationPath="uploads/products_images/thumbnail/";
                $table->thumbnail_image = $destinationPath.$input['image'];
            } catch (exception $e) { }
        }
        $table->visibility = $status;
        $table->save();
        \App\SellerProducts::create([
            'agent_id' => $request->seller_id,
            'product_id' => \App\Products::orderby('created_at','DESC')->firstOrFail()->id
        ]);
        return back()->with('success', $request->name.' - product has been successfully added!');
    }

    public function show($id)
    {
        if(\auth::user()->haspermission('read-products')) {

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Products(),
                'property' => \App\Products::find($id),
                'type' => 'Read',
                'log' => 'Check Product Details Read By ' . \Auth::user()->name,
            ]));
            return view('backend.products.view')->with(
                ['data' => \App\Products::where('id', $id)->firstOrFail()]
            );
        }

        abort(403);
    }

    public function edit($id)
    {
        return view('backend.products.edit')->with(
            ['data' => \App\Products::where('id',$id)->firstOrFail()]
        );
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'product_type.required' => 'The product category field is required.',
            'name.required' => 'The product name field is required.',
            'name.unique' => 'The product name has been already assigned.',
            'stock.required' => 'The product stock field is required.',
            'order.unique' => 'The sequence has already been assigned.',
            'item_code.unique' => 'The product code has already been assigned.'
        ];

        $this->validate($request, [
            'product_type' => 'required',
            'name' =>  ['required',
                Rule::unique('products')
                    ->wherenot('id', $id)
                    ->where('name', $request->input('name'))
            ],
            'price' => 'required',
            'actual_price' => 'required',
            'seller_paid' => 'required',
            'seller_id' => 'required',
            'stock' => 'required',
            'item_code' =>  [
                Rule::unique('products')
                    ->wherenot('id', $id)
                    ->where('item_code', $request->input('item_code'))
            ],
            'order' => ['nullable', Rule::unique('products')
                ->wherenot('id', $id)
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $category_id=null; $is_negotiable=0; $is_deliverable=0; $status=0;
//        if(!is_null($request->is_negotiable_val)){ $is_negotiable = 1; }
        if(!is_null($request->is_deliverable_val)){ $is_deliverable = 1; }
        if(!is_null($request->visibility_status)){ $status = 1; }

        if($request->product_type){ $category_id = $request->product_type; }
        if(($request->product_type && !empty($request->product_type)) && ($request->item_category && !empty($request->item_category))){
            $category_id = $request->item_category;
        }
        if(($request->product_type && !empty($request->product_type)) && ($request->item_category && !empty($request->item_category)) && ($request->item_sub_category && !empty($request->item_sub_category))){
            $category_id = $request->item_sub_category;
        }

        $table = \App\Products::where('id',$id)->first();
        $table->update($request->all());
        $table->update([
            'category_id' => $category_id,
            'is_deliverable' => $is_deliverable,
            'visibility' => $status,
            'slug' => make_slug($request->input('name'))
        ]);
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $input['image'] = "pro_img_".rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/products_images/thumbnail');
                if (!file_exists($destinationPath)) { mkdir($destinationPath, 0777); }
                $img1 = Image::make($image->path());
                $img1->resize(540, 550);
                $img1->save($destinationPath . '/' . $input['image']);
                $destinationPath = public_path('/uploads/products_images');
                $image->move($destinationPath, $input['image']);
                $destinationPath="uploads/products_images/";
                $table->update([
                    'image' => $destinationPath.$input['image'],
                ]);
                $destinationPath="uploads/products_images/thumbnail/";
                $table->update([
                    'thumbnail_image' => $destinationPath.$input['image'],
                ]);
            } catch (exception $e) { }
        }
        \App\SellerProducts::where('product_id',$id)->update([
            'agent_id' => $request->seller_id,
        ]);
        return redirect()->route('products.index')->with('success', $request->name.' - product has been successfully updated!');
    }

    public function destroy($id)
    {
        $table = \App\Products::find($id);
//        \App\Products::where('id',$id)->update(['is_deleted' => \Carbon\Carbon::now()]);
        $table_order_items=\App\Order_items::where('product_id',$id)->first();
        if($table_order_items){
            return redirect()->back()->with('error',$table->name." - product cannot delete, due to order has this product.");
        }else{
            \App\Products::where('id',$id)->delete();
        }
        return redirect()->back()->with('success', $table->name.' - product has been successfully deleted!');
    }

    public function destroy_all()
    {
        foreach(\App\Products::all() as $row){
//            \App\Products::where('id',$row->id)->update(['is_deleted' => \Carbon\Carbon::now()]);
            \App\Products::where('id',$row->id)->delete();
        }
        return redirect()->back()->with('success', 'All product has been successfully cleared!');
    }

    public function add_more_image(Request $request){
        $this->validate($request, [
            'image' => 'required',
        ]);

        if(\App\Products::where('id',$request->input('product_id'))->first()->images->count()<4) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $input['image'] = "pro_img_" . rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/products_images/thumbnail');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $img1 = Image::make($image->path());
                $img1->resize(540, 550);
                $img1->save($destinationPath . '/' . $input['image']);
                $destinationPath = public_path('/uploads/products_images');
                $image->move($destinationPath, $input['image']);
                $destinationPath = "uploads/products_images/";
                $table = \App\Product_images::create([
                    'product_id' => $request->input('product_id'),
                    'image' => $destinationPath . $input['image'],
                ]);
                $destinationPath = "uploads/products_images/thumbnail/";
                $table->image_thumbnail = $destinationPath . $input['image'];
                $table->save();
            }else{
                return redirect()->back()->with('error','Please upload image.');
            }
        }else{
            return redirect()->back()->with('error','Can\t able to add more than 5 images per Product.');
        }

        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_images(),
            'property' => isset($table->id)? \App\Product_images::find($table->id): null,
            'type' => 'Create',
            'log' => 'Create Product More Images Created By ' . \Auth::user()->name,
        ]));

        return redirect()->back()->with('success',\App\Products::where('id',$request->input('product_id'))->first()->name.' Product Image has been successfully added!');
    }

    public function delete_more_image(Request $request){

        \App\Product_images::where('id',$request->input('image_id'))->delete();
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_images(),
            'property' => \App\Product_images::find($request->input('image_id')),
            'type' => 'Delete',
            'log' => 'Delete Product More Images Deleted By ' . \auth::user()->name,
        ]));
        return redirect()->back()->with('success',\App\Products::where('id',$request->input('product_id'))->first()->name.' Product Image has been deleted!');
    }

    public function remove_product_review(Request $request){
        if(\auth::user()->haspermission('delete-user-review')){

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Product_reviews(),
                'property' => \App\Product_reviews::find($request->input('review_id')),
                'type' => 'Delete',
                'log' => 'Remove Product Review Comment Deleted By ' . \auth::user()->name,
            ]));

            \App\Product_reviews::where('id', $request->input('review_id'))->update([
                'is_deleted' => \Carbon\Carbon::now()
            ]);
            return redirect()->back()->with('success', \App\Products::where('id', $request->input('product_id'))->first()->name . '\'s product review has been trashed.');
        }
        abort(403);
    }

    public function reply_review(Request $request){
        if(\auth::user()->haspermission('create-review-reply')){
            $table=\App\ProductReviewReply::create($request->all());
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\ProductReviewReply(),
                'property' => \App\ProductReviewReply::find($table->id),
                'type' => 'Create',
                'log' => 'Create Product Review Reply Commented By ' . \auth::user()->name,
            ]));
            return redirect()->back()->with('success', 'Review has been replied.');
        }
        abort(403);
    }

    public function remove_product_review_reply(Request $request){
        if(\auth::user()->haspermission('delete-review-reply')){
            \App\ProductReviewReply::findOrFail($request->input('reply_id'))->update([
                'is_deleted' => \Carbon\Carbon::now()
            ]);
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\ProductReviewReply(),
                'property' => \App\ProductReviewReply::find($request->input('reply_id')),
                'type' => 'Delete',
                'log' => 'Delete Product Review Reply Deleted By ' . \auth::user()->name,
            ]));
            return redirect()->back()->with('success', 'Review Reply has been removed.');
        }
        abort(403);
    }

}
