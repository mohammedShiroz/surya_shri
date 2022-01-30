<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Observers\ActivityLogObserver;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        \App\Product_category::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_category(),
            'property' => ['name' => 'Check Product Categories List'],
            'type' => 'Read',
            'log' => 'Check Product Categories List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.products.category.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'The product category name field is required.',
            'name.unique' => 'The product category name has already been added.',
            'order.unique' => 'The sequence has already been assigned.'
        ];
        $this->validate($request, [
            'name' => 'required|unique:product_categories,name,NULL,'.$request->input('name').',parent_id,NULL',
            'order' => ['nullable', Rule::unique('product_categories')
                ->whereNull('parent_id')
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $table=\App\Product_category::create($request->all());
        $status=0;
        if(!is_null($request->visibility_status)){ $status = 1; }
        $table->visibility = $status;
        $table->save();
        return back()->with('success', $request->name.' - product category has been successfully added!');
    }

    public function store_sub_category(Request $request)
    {
        $messages = [
            'name.required' => 'The category name field is required.',
            'name.unique' => 'The category name has already been added.',
            'order.unique' => 'The sequence has already been assigned.'
        ];
        $this->validate($request, [
            'name' => 'required|unique:product_categories,name,NULL,'.$request->input('name').',parent_id,'.$request->input('parent_id'),
            'order' => ['nullable', Rule::unique('product_categories')
                ->where('parent_id',$request->input('parent_id'))
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $table=\App\Product_category::create($request->all());
        $status=0;
        if(!is_null($request->input('visibility_status'))){ $status = 1; }
        $table->visibility = $status;
        $table->save();

        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_category(),
            'property' => \App\Product_category::find($table->id),
            'type' => 'Create',
            'log' => 'Create Product Sub Category Created By ' . \Auth::user()->name,
        ]));
        return back()->with('success', $request->input('name').' - category has been successfully added!');
    }

    public function update_sub_category(Request $request,$id)
    {
        $messages = [
            'name.required' => 'The category name field is required.',
            'name.unique' => 'The category name has already been added.',
            'order.unique' => 'The sequence has already been assigned.'
        ];
        $this->validate($request, [
            'name' => ['required', Rule::unique('product_categories')
                ->where('parent_id',$request->input('parent_id'))
                ->whereNot('id', $id)
                ->where('name', $request->input('name'))],
            'order' => ['nullable', Rule::unique('product_categories')
                ->where('parent_id',$request->input('parent_id'))
                ->whereNot('id', $id)
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_category(),
            'property' => \App\Product_category::find($id),
            'type' => 'Update',
            'log' => 'Update Product Sub Category Details Update By ' . \Auth::user()->name,
        ]));

        $status=0;
        if(!is_null($request->input('visibility_status'))){ $status = 1; }
        $table = \App\Product_category::findOrFail($id);
        $table->update($request->all());
        $table->update(['visibility' => $status]);
        if($request->input('is_category_three')){
           return redirect()->route('product-category.show_third_category', [$request->input('main_category_id'), $request->input('parent_id')])->with('success', $request->input('name') . ' - category has been successfully updated!');
        }
        return redirect()->route('product-category.show',$request->input('parent_id'))->with('success', $request->input('name') . ' - category has been successfully updated!');
    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_category(),
            'property' => \App\Product_category::find($id),
            'type' => 'Read',
            'log' => 'Check Product Category Details Read By ' . \Auth::user()->name,
        ]));

        return view('backend.products.category.subcategory_one')->with(
            ['data' => \App\Product_category::find($id)]
        );
    }

    public function show_sub_category($parent_id, $id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_category(),
            'property' => \App\Product_category::find($id),
            'type' => 'Read',
            'log' => 'Check Product Sub Category Details Read By ' . \Auth::user()->name,
        ]));

        return view('backend.products.category.subcategory_two')->with(
            [
                'data' => \App\Product_category::where('id',$id)->firstOrFail(),
            ]
        );
    }

    public function edit($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_category(),
            'property' => \App\Product_category::find($id),
            'type' => 'Edit',
            'log' => 'Edit Product Category Details Edit By ' . \Auth::user()->name,
        ]));

        return view('backend.products.category.index')->with(
            ['data' => \App\Product_category::find($id), 'edit_enabled' =>'true']
        );
    }

    public function edit_sub_category($parent_id,$id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_category(),
            'property' => \App\Product_category::find($id),
            'type' => 'Edit',
            'log' => 'Edit Product Level Two Category Details Edit By ' . \Auth::user()->name,
        ]));

        return view('backend.products.category.subcategory_one')->with(
            [
                'data' => \App\Product_category::where('id',$parent_id)->firstOrFail(),
                'data_two' => \App\Product_category::where('id',$id)->firstOrFail(),
                'edit_enabled' =>'true',
            ]
        );
    }

    public function edit_third_sub_category($parent_id, $sub_id, $id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Product_category(),
            'property' => \App\Product_category::find($id),
            'type' => 'Edit',
            'log' => 'Edit Product Level Three Category Details Edit By ' . \Auth::user()->name,
        ]));

        return view('backend.products.category.subcategory_two')->with(
            [
                'data' => \App\Product_category::where('id',$sub_id)->firstOrFail(),
                'data_two' => \App\Product_category::where('id',$id)->firstOrFail(),
                'edit_enabled' =>'true',
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'The product category name field is required.',
            'name.unique' => 'The product category name has already been added.',
            'order.unique' => 'The sequence has already been assigned.'
        ];

        $this->validate($request, [
            'name' => 'required|unique:product_categories,name,NULL,'.$request->input('name').',parent_id,NULL',
            'name' => ['required', Rule::unique('product_categories')
                ->whereNull('parent_id')
                ->whereNot('id', $id)
                ->where('name', $request->input('name'))],
            'order' => ['nullable', Rule::unique('product_categories')
                ->whereNull('parent_id')
                ->whereNot('id', $id)
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $status=0;
        if(!is_null($request->input('visibility_status'))){ $status = 1; }
        $table = \App\Product_category::find($id);
        $table->update($request->all());
        $table->update(['visibility' => $status]);
        return redirect()->route('product-category.index')->with('success', $request->input('name').' - product category has been successfully updated!');
    }

    public function destroy($id)
    {
        $table = \App\Product_category::find($id);
        \App\Product_category::where('id',$id)->delete();
//        \App\Product_category::where('id',$id)->update(['is_deleted'=> \Carbon\Carbon::now()]);
        return back()->with('success', $table->name.' - product category has been successfully deleted!');
    }

    public function destroy_all()
    {
        foreach(\App\Product_category::all() as $row){
            \App\Product_category::where('id',$row->id)->delete();
//            \App\Product_category::where('id',$row->id)->update(['is_deleted'=> \Carbon\Carbon::now()]);
        }
        return back()->with('success', 'All product category has been successfully cleared!');
    }
}
