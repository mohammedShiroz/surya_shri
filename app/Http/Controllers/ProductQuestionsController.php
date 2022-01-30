<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class ProductQuestionsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function fetch_question_answers(Request $request){

        $data = null;
        $alphas = range('a', 'z');
        if($request->ajax()) {
            foreach (\App\Answers::where('question_id', $request->id)->orderby('order', 'asc')->get() as $k=>$row) {
                $data .= "<option value='" . $row->id . "' ".(($k == '0')? 'selected': '')."> <small>(".$alphas[(($row->order)? ($row->order-1) : ($k))].")</small> ".$row->answer . "</option>";
            }
        }
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'question_id' =>  [ 'required',
                Rule::unique('product__questions__answers')
                    ->where('product_id', $request->product_id)
                    ->where('question_id', $request->question_id)
            ],
            'answer_id' => 'required'
        ]);
        foreach ($request->input('answer_id') as $k=>$row) {
            \App\Product_Questions_Answers::create([
                'product_id'=> $request->input('product_id'),
                'question_id' => $request->input('question_id'),
                'answer_id' => $row
            ]);
        }
        return back()->with('success', \App\Products::find($request->input('product_id'))->name.' - product question and answer has been added!');
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
        $table=\App\Product_Questions_Answers::find($id);
        \App\Product_Questions_Answers::where('product_id', $table->product_id)
            ->where('question_id', $table->question_id)->delete();
        return back()->with('success', 'Deleted!');
    }
}
