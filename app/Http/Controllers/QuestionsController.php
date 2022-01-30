<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Observers\ActivityLogObserver;

class QuestionsController extends Controller
{
    public function __construct()
    {
        \App\Questions::observe(ActivityLogObserver::class);
    }

    public function index(Request $request)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Questions(),
            'property' => ['name' => 'Check Questions List'],
            'type' => 'Read',
            'log' => 'Check Questions List Read By ' . \Auth::user()->name,
        ]));
        return view('backend.questionnaire.questions.index');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $messages = [
            'question.unique' => 'The question has already been added.',
            'order.unique' => 'The sequence has already been assigned.'
        ];
        $this->validate($request, [
            'question' => 'required|unique:questions,question,NULL,question'.$request->input('question'),
            'order' => ['nullable', Rule::unique('questions')->where('order', $request->input('order'))]
        ],$messages);

        $table = \App\Questions::create($request->all());
        $status=0;
        if(!is_null($request->input('visibility_status'))){ $status = 1; }
        $table->visibility = $status;
        $table->save();
        return back()->with('success', $request->input('question').' - question has been added!');
    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Questions(),
            'property' => \App\Questions::find($id),
            'type' => 'Read',
            'log' => 'Check Questions Details Read By ' . \Auth::user()->name,
        ]));

        return view('backend.questionnaire.questions.show')->with(
            ['data' => \App\Questions::where('id',$id)->firstOrFail()]
        );
    }

    public function edit($id)
    {
        return view('backend.questionnaire.questions.index')->with(
            ['data' => \App\Questions::where('id',$id)->firstOrFail(), 'edit_enabled' =>'true']
        );
    }

    public function edit_answer($id, $answer_id)
    {
        return view('backend.questionnaire.questions.show')->with(
            [
                'data' => \App\Questions::where('id',$id)->firstOrFail(),
                'data_answer' => \App\Answers::where('id',$answer_id)->firstOrFail(), 'edit_enabled' =>'true',
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'question.unique' => 'The question has already been added.',
            'order.unique' => 'The sequence has already been assigned.'
        ];

        $this->validate($request, [
            'question' => ['required', Rule::unique('questions')
                ->whereNot('id', $id)
                ->where('question', $request->input('question'))],
            'order' => ['nullable', Rule::unique('questions')
                ->whereNot('id', $id)
                ->where('order', $request->input('order'))]
        ],$messages);

        $status=0;
        if(!is_null($request->visibility_status)){ $status = 1; }
        $table = \App\Questions::findOrFail($id);
        $table->update($request->all());
        $table->update(['visibility' => $status]);
        return redirect()->route('questions.index')->with('success', $request->question.' - question has been updated!');
    }

    public function destroy($id)
    {
        $table = \App\Questions::find($id);
        \App\Questions::where('id',$id)->delete();
        // \App\Questions::where('id',$id)->update(['is_deleted' => \Carbon\Carbon::now()]);
        return back()->with('success',  $table->question.' - question has been deleted!');
    }

    public function destroy_all()
    {

        foreach (\App\Questions::all() as $row){
            \App\Questions::where('id',$row->id)->delete();
//            \App\Questions::where('id',$row->id)->update(['is_deleted' => \Carbon\Carbon::now()]);
        }
        return back()->with('success', 'All questions has been cleared!');
    }
}
