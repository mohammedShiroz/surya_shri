<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function store(Request $request)
    {
        if (\auth::check()) {
            activity()
                ->performedOn($request->model)
                ->causedBy(\auth::user())
                ->withProperties($request->property)
                ->inLog($request->type)
                ->log($request->log ? $request->log : class_basename($request->model) . ' ' . $request->type . 'd By ' . \auth::user()->name);
        } else {
            activity()
                ->performedOn($request->model)
                ->byAnonymous()
                ->withProperties($request->property)
                ->inLog($request->type)
                ->log($request->log);
        }
    }
}
