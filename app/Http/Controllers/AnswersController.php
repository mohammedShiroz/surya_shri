<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class AnswersController extends Controller
{
    public function __construct()
    {
        \App\Answers::observe(ActivityLogObserver::class);
    }

    public function index(Request $request)
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'question_id' => 'required',
            'answer' => 'required|unique:answers,answer,NULL,question_id,question_id,'.$request->question_id
        ]);

        if(\App\Answers::where('question_id',$request->input('question_id'))->get()->count() < 3) {
            $table = \App\Answers::create($request->all());
            $status = 0;
            if (!is_null($request->visibility_status)) {
                $status = 1;
            }
            $table->visibility = $status;
            $table->save();
            return back()->with('success', $request->input('answer') . ' - answers has been added!');
        }else{
            return back()->with('error', 'Unable to add more than 3 answers per question!');
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'question_id' => 'required',
            'answer' => 'required',
        ]);

        $status=0;
        if(!is_null($request->visibility_status)){ $status = 1; }
        $table = \App\Answers::findOrFail($id);
        $table->update($request->all());
        $table->update(['visibility' => $status]);
        return redirect()->route('questions.show',$request->question_id)->with('success', $request->answer.' - answer has been updated!');
    }

    public function destroy($id)
    {
        $table = \App\Answers::find($id);
        \App\Answers::where('id',$id)->update(['is_deleted' => \Carbon\Carbon::now()]);
        return back()->with('success',  $table->answer.' - answer has been deleted!');
    }

    public function destroy_all()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Answers::query()->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return back()->with('success', 'All questions\s answers has been cleared!');
    }
}
