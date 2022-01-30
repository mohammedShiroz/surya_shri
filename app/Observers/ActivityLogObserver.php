<?php

namespace App\Observers;

use App\ActivityLog;
use Illuminate\Support\Facades\Auth;
class ActivityLogObserver
{

//    public function saved($model)
//    {
//        if (Auth::check()) {
//            activity()
//                ->performedOn($model)
//                ->causedBy(Auth::id())
//                ->withProperties($model)
//                ->inLog('Create')
//                ->log(class_basename($model) . ' created By ' . Auth::user()->name);
//        } else {
//            activity()
//                ->performedOn($model)
//                ->byAnonymous()
//                ->withProperties($model)
//                ->inLog('Create')
//                ->log(class_basename($model) . ' created By ');
//        }
//    }

    public function created($model)
    {
        if (Auth::check()) {
            activity()
                ->performedOn($model)
                ->causedBy(Auth::user())
                ->withProperties($model)
                ->inLog('Create')
                ->log(class_basename($model) . ' Create By ' . Auth::user()->name);
        } else {
            activity()
                ->performedOn($model)
                ->byAnonymous()
                ->withProperties($model)
                ->inLog('Create')
                ->log(class_basename($model) . ' Create By ');
        }
    }

    public function retrieved($model)
    {
//        if (Auth::check()) {
//            activity()
//                ->performedOn($model)
//                ->causedBy(Auth::id())
//                ->withProperties($model)
//                ->inLog('Read')
//                ->log(class_basename($model) . ' read By ' . Auth::user()->name);
//        } else {
//            activity()
//                ->performedOn($model)
//                ->byAnonymous()
//                ->withProperties($model)
//                ->inLog('Read')
//                ->log(class_basename($model) . ' read By ');
//        }
    }


    public function updated($model)
    {
        if (Auth::check()) {
            activity()
                ->performedOn($model)
                ->causedBy(Auth::id())
                ->withProperties($model)
                ->inLog('Update')
                ->log(class_basename($model) . ' updated By ' . Auth::user()->name);
        } else {
            activity()
                ->performedOn($model)
                ->byAnonymous()
                ->withProperties($model)
                ->inLog('Update')
                ->log(class_basename($model) . ' updated By ');
        }
    }

    public function deleted($model)
    {
        if (Auth::check()) {
            activity()
                ->performedOn($model)
                ->causedBy(Auth::id())
                ->withProperties($model)
                ->inLog('Delete')
                ->log(class_basename($model) . ' deleted By ' . Auth::user()->name);
        } else {
            activity()
                ->performedOn($model)
                ->byAnonymous()
                ->withProperties($model)
                ->inLog('Delete')
                ->log(class_basename($model) . ' deleted By ');
        }
    }

    public function restored(ActivityLog $activityLog)
    {
        //
    }


    public function forceDeleted(ActivityLog $activityLog)
    {
        //
    }
}
