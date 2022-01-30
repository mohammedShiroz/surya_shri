<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Illuminate\Validation\Rule;
use App\Observers\ActivityLogObserver;

class ServiceController extends Controller
{
    public function __construct()
    {
        \App\Service::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        if(\auth::user()->haspermission('read-service')) {

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service(),
                'property' => ['name' => 'Check Services List'],
                'type' => 'Read',
                'log' => 'Check Services List Read By ' . \Auth::user()->name,
            ]));

            return view('backend.services.index');
        }
        abort(403);
    }

    public function create()
    {
        return view('backend.services.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'category_id.required' => 'The service category field is required.',
            'name.required' => 'The service name field is required.',
            'name.unique' => 'The service name has been already assigned.',
            'order.unique' => 'The sequence has already been assigned.',
            'service_code.unique' => 'The service code has already been assigned.'
        ];

        $this->validate($request, [
            'category_id' => 'required',
            'name' =>  ['required',
                Rule::unique('services')
                    ->where('name', $request->input('name'))
            ],
            'price' => 'required',
            'service_code' =>  [ 'required',
                Rule::unique('services')
                    ->where('service_code', $request->input('service_code'))
            ],
            'actual_price' => 'required',
            'seller_paid' => 'required',
            'description' => 'max:390',
            'order' => ['nullable', Rule::unique('services')
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $status=0; if(!is_null($request->input('visibility_status'))){ $status = 1; }
        $av_days=null;
        if($request->available_day){
            foreach($request->available_day as $k=>$val){
                if ($k === array_key_last($request->available_day)) {
                    $av_days .= $val;
                }else{
                    $av_days .= $val.',';
                }
            }
        }
        $table=\App\Service::create($request->all());
        $table->slug = make_slug($request->input('name'));
        $table->week_days = $av_days;
        $table->save();

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $input['image'] = "services_img_".rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/services_images/thumbnail');
                if (!file_exists($destinationPath)) { mkdir($destinationPath, 0777); }
                $img1 = Image::make($image->path());
                $img1->resize(540, 550);
                $img1->save($destinationPath . '/' . $input['image']);
                $destinationPath = public_path('/uploads/services_images');
                $image->move($destinationPath, $input['image']);
                $destinationPath="uploads/services_images/";
                $table->image = $destinationPath.$input['image'];
                $destinationPath="uploads/services_images/thumbnail/";
                $table->thumbnail_image = $destinationPath.$input['image'];
            } catch (exception $e) { }
        }
        $table->visibility = $status;
        $table->save();
        return back()->with('success', $request->input('name').' - Service has been successfully added!');
    }

    public function show($id)
    {
        if(\auth::user()->haspermission('read-service')) {
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service(),
                'property' => \App\Service::find($id),
                'type' => 'Read',
                'log' => 'Check Product Details Read By ' . \Auth::user()->name,
            ]));

            return view('backend.services.view')->with(
                ['data' => \App\Service::find($id)]
            );
        }

        abort(403);
    }

    public function edit($id)
    {
        return view('backend.services.edit')->with(
            ['data' => \App\Service::find($id)]
        );
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'category_id.required' => 'The service category field is required.',
            'name.required' => 'The service name field is required.',
            'name.unique' => 'The service name has been already assigned.',
            'order.unique' => 'The sequence has already been assigned.',
            'service_code.unique' => 'The service code has already been assigned.'
        ];

        $this->validate($request, [
            'category_id' => 'required',
            'name' =>  ['required',
                Rule::unique('services')
                    ->whereNot('id', $id)
                    ->where('name', $request->input('name'))
            ],
            'price' => 'required',
            'service_code' =>  [ 'required',
                Rule::unique('services')
                    ->wherenot('id', $id)
                    ->where('service_code', $request->input('service_code'))
            ],
            'actual_price' => 'required',
            'seller_paid' => 'required',
            'description' => 'max:390',
            'order' => ['nullable', Rule::unique('services')
                ->whereNot('id', $id)
                ->where('order', $request->input('order'))
            ]
        ],$messages);

        $status=0; $week_days=null;
        if($request->week_days){
            $week_days =$request->week_days;
        }

        if(!is_null($request->visibility_status)){ $status = 1; }
        $table = \App\Service::findOrFail($id);
        $table->update($request->all());
        $table->update([
            'visibility' => $status,
            'week_days' =>$week_days,
            'slug' => make_slug($request->input('name'))
        ]);
        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $input['image'] = "services_img_".rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/services_images/thumbnail');
                if (!file_exists($destinationPath)) { mkdir($destinationPath, 0777); }
                $img1 = Image::make($image->path());
                $img1->resize(540, 550);
                $img1->save($destinationPath . '/' . $input['image']);
                $destinationPath = public_path('/uploads/services_images');
                $image->move($destinationPath, $input['image']);
                $destinationPath="uploads/services_images/";
                $table->update([
                    'image' => $destinationPath.$input['image'],
                ]);
                $destinationPath="uploads/services_images/thumbnail/";
                $table->update([
                    'thumbnail_image' => $destinationPath.$input['image'],
                ]);
            } catch (exception $e) { }
        }
        return redirect()->route('services.index')->with('success', $request->name.' - Service has been successfully updated!');
    }


    public function remove_service_review(Request $request){
        if(\auth::user()->haspermission('delete-user-review')){

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Service_review(),
                'property' => \App\Service_review::find($request->input('review_id')),
                'type' => 'Delete',
                'log' => 'Remove Services Review Comment Delete By ' . \Auth::user()->name,
            ]));

            \App\Service_review::where('id', $request->input('review_id'))->update([
                'is_deleted' => \Carbon\Carbon::now()
            ]);
            return redirect()->back()->with('success', \App\Service::where('id', $request->input('service_id'))->first()->name . '\'s service review has been trashed.');
        }
        abort(403);
    }

    public function reply_review(Request $request){
        if(\auth::user()->haspermission('create-review-reply')){
            $table=\App\ServiceReviewReply::create($request->all());

            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\ServiceReviewReply(),
                'property' => \App\ServiceReviewReply::find($table->id),
                'type' => 'Create',
                'log' => 'Create Services Review Reply Commented By ' . \auth::user()->name,
            ]));
            return redirect()->back()->with('success', 'Review has been replied.');
        }
        abort(403);
    }

    public function remove_service_review_reply(Request $request){
        if(\auth::user()->haspermission('delete-review-reply')){
            \App\ServiceReviewReply::findOrFail($request->input('reply_id'))->update([
                'is_deleted' => \Carbon\Carbon::now()
            ]);
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\ServiceReviewReply(),
                'property' => \App\ServiceReviewReply::find($request->input('reply_id')),
                'type' => 'Delete',
                'log' => 'Delete Services Review Reply Deleted By ' . \auth::user()->name,
            ]));
            return redirect()->back()->with('success', 'Review Reply has been removed.');
        }
        abort(403);
    }

    public function destroy($id)
    {
        $table=\App\Service::where('id',$id)->first();
        $table->delete();
        return back()->with('success', $table->name.' - Service has been successfully deleted!');
    }

    public function destroy_all()
    {
        foreach(\App\Service::all() as $row){
            \App\Service::where('id',$row->id)->delete();
        }
        return back()->with('success', 'All service has been successfully cleared!');
    }


    public function add_more_image(Request $request){
        $this->validate($request, [
            'image' => 'required',
        ]);

        if(\App\Service::where('id',$request->input('service_id'))->first()->images->count()<4) {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $input['image'] = "pro_img_" . rand(10, 1000) . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('uploads/services_images/thumbnail');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777);
                }
                $img1 = Image::make($image->path());
                $img1->resize(540, 550);
                $img1->save($destinationPath . '/' . $input['image']);
                $destinationPath = public_path('/uploads/services_images');
                $image->move($destinationPath, $input['image']);
                $destinationPath = "uploads/services_images/";
                $table = \App\Service_images::create([
                    'service_id' => $request->input('service_id'),
                    'image' => $destinationPath . $input['image'],
                ]);
                $destinationPath = "uploads/services_images/thumbnail/";
                $table->image_thumbnail = $destinationPath . $input['image'];
                $table->save();
            }else{
                return redirect()->back()->with('error','Please upload image.');
            }
        }else{
            return redirect()->back()->with('error','Can\t able to add more than 5 images per service.');
        }

        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_images(),
            'property' => isset($table->id)? \App\Service_images::find($table->id): null,
            'type' => 'Create',
            'log' => 'Create Service More Images Created By ' . \Auth::user()->name,
        ]));

        return redirect()->back()->with('success',\App\Service::where('id',$request->input('service_id'))->first()->name.' Service Image has been successfully added!');
    }

    public function delete_more_image(Request $request){

        \App\Service_images::where('id',$request->input('image_id'))->delete();
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Service_images(),
            'property' => \App\Service_images::find($request->input('image_id')),
            'type' => 'Delete',
            'log' => 'Delete Service More Images Deleted By ' . \Auth::user()->name,
        ]));
        return redirect()->back()->with('success',\App\Service::where('id',$request->input('service_id'))->first()->name.' Service Image has been deleted!');
    }
}
