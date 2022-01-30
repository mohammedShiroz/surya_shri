<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Observers\ActivityLogObserver;


class ServiceCategoryController extends Controller
{
    public function __construct()
    {
        \App\Service_category::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_category(),
            'property' => ['name' => 'Check Services Categories List'],
            'type' => 'Read',
            'log' => 'Services Categories List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.services.category.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'The category name field is required.',
            'name.unique' => 'The category name has been already assigned.',
            'order.unique' => 'The sequence has already been assigned.',
        ];

        $this->validate($request, [
            'name' =>  ['required',
                Rule::unique('service_categories')
                    ->where('name', $request->input('name'))
            ],
            'order' => ['nullable', Rule::unique('service_categories')
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $table=\App\Service_category::create($request->all());
        $status=0;
        if(!is_null($request->input('visibility_status'))){ $status = 1; }
        $table->visibility = $status;
        $table->save();
        return back()->with('success', $request->input('name').' - service category has been successfully added!');
    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_category(),
            'property' => \App\Service_category::find($id),
            'type' => 'Read',
            'log' => 'Check Service Category Details Read By ' . \Auth::user()->name,
        ]));

        return view('backend.services.category.view')->with(
            ['data' => \App\Service_category::where('id',$id)->firstOrFail()]
        );
    }

    public function edit($id)
    {
        return view('backend.services.category.index')->with(
            ['data' => \App\Service_category::where('id',$id)->firstOrFail(), 'edit_enabled' =>'true']
        );
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'name.required' => 'The category name field is required.',
            'name.unique' => 'The category name has been already assigned.',
            'order.unique' => 'The sequence has already been assigned.',
        ];

        $this->validate($request, [
            'name' =>  ['required',
                Rule::unique('service_categories')
                    ->whereNot('id', $id)
                    ->where('name', $request->input('name'))
            ],
            'order' => ['nullable', Rule::unique('service_categories')
                ->whereNot('id', $id)
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $status=0;
        if(!is_null($request->visibility_status)){ $status = 1; }
        $table = \App\Service_category::findOrFail($id);
        $table->update($request->all());
        $table->update(['visibility' => $status]);
        return redirect()->route('service-category.index')->with('success', $request->name.' - service category has been successfully updated!');
    }

    public function destroy($id)
    {
        $table = \App\Service_category::findOrFail($id);
        \App\Service_category::destroy($id);
        return back()->with('success',  $table->name.' - service category has been successfully deleted!');
    }

    public function destroy_all()
    {
        \App\Service_category::query()->truncate();
        return back()->with('success', 'All service category has been successfully cleared!');
    }
}
