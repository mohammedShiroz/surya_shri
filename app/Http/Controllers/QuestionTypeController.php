<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionTypeController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth:admin');
//    }

    public function index()
    {
        return view('backend.questionnaire.question_type.index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:questiontypes',
        ]);

        $table=\App\Questiontype::create($request->all());
        $status=0;
        if(!is_null($request->visibility_status)){ $status = 1; }
        $table->visibility = $status;
        $table->save();
        return back()->with('success', $request->name.' - question type data has been successfully added!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('backend.questionnaire.question_type.index')->with(
            ['data' => \App\Questiontype::where('id',$id)->firstOrFail(), 'edit_enabled' =>'true']
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $status=0;
        if(!is_null($request->visibility_status)){ $status = 1; }
        $table = \App\Questiontype::findOrFail($id);
        $table->update($request->all());
        $table->update(['visibility' => $status]);
        return redirect()->route('question-type.index')->with('success', $request->name.' - question type data has been successfully updated!');
    }

    public function destroy($id)
    {
        $table = \App\Questiontype::findOrFail($id);
        \App\Questiontype::destroy($id);
        return back()->with('success',  $table->name.' - question type data has been successfully deleted!');
    }

    public function destroy_all()
    {
        \App\Questiontype::query()->truncate();
        return back()->with('success', 'All question type data has been successfully cleared!');
    }
}
