<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServicesQuestionsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'service_id' => 'required',
            'question_id' =>  [
                'required',
                Rule::unique('service_questions_answers')
                    ->where('service_id', $request->service_id)
                    ->where('question_id', $request->question_id)
            ],
            'answer_id' => 'required'
        ]);
        foreach ($request->input('answer_id') as $k=>$row) {
            \App\Service_questions_answers::create([
                'service_id'=> $request->input('service_id'),
                'question_id' => $request->input('question_id'),
                'answer_id' => $row
            ]);
        }
        return back()->with('success', \App\Service::find($request->input('service_id'))->name.' - service question and answer has been added!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $table=\App\Service_questions_answers::find($id);
        \App\Service_questions_answers::where('service_id', $table->service_id)
            ->where('question_id', $table->question_id)->delete();
        return back()->with('success', 'Deleted!');
    }
}
