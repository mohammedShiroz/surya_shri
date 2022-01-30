<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;

class SubmittedQuestionnairesController extends Controller
{
    public function __construct()
    {
        \App\Customers_answers::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        if(\auth::user()->haspermission('read-submitted-questionnaires')) {
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Customers_answers(),
                'property' => ['name' => 'Check Submitted Questionnaires List'],
                'type' => 'Read',
                'log' => 'Check Submitted Questionnaires List Read By ' . \Auth::user()->name,
            ]));
            return view('backend.questionnaire.submitted.index');
        }
        abort(403);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Customers_answers(),
            'property' => \App\Customers_answers::find($id),
            'type' => 'Read',
            'log' => 'Check Submitted Questionnaires Details Read By ' . \Auth::user()->name,
        ]));

        return view('backend.questionnaire.submitted.show')->with(
            ['data' => \App\Customers_answers::where('id',$id)->firstOrFail()]
        );
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
        //
    }
}
