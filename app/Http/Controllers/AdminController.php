<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DateTime;
use App\Observers\ActivityLogObserver;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        \App\Admins::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Admins(),
            'property' => ['name' => 'Check Dashboard'],
            'type' => 'Read',
            'log' => 'Check Dashboard Read By ' . \Auth::user()->name,
        ]));
        return view('backend.dashboard');
    }

    function get_coming_up_bookings(){

        $dates=\App\Service_booking::all();
        $data_events = array();
        $get_color=null; $text_color=null;
        foreach($dates as $row){
            if($row->status == "Pending"){$get_color = "orange"; $text_color="event-pending";}
            elseif($row->status == "Confirmed"){ $get_color = "green"; $text_color="event-confirmed";}
            elseif($row->status == "Rejected"){ $get_color = "black"; $text_color="event-rejected";}
            elseif($row->status == "Canceled"){ $get_color = "red"; $text_color="event-canceled";}
            elseif($row->status == "Completed"){ $get_color = "dark-green"; $text_color="event-completed";}

            if(\Carbon\Carbon::now()->subDays(1)->between(new DateTime(), new DateTime($row->book_date))){ $get_color = "dark-red"; $text_color="event-expiry";  }

            $data_events[] = array(
                "id" => $row->id,
                "date" => $row->book_date,
                "eventName" => $row->customer->name,
                "calendar" => 'work',
                "url" => 'work',
                "color" => $get_color,
                'text_color' => $text_color,
            );
        }
        return response()->json($data_events);
        exit();
    }

    public function show_profile(){
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Admins(),
            'property' => \App\Admins::find(\Auth::user()->id),
            'type' => 'Read',
            'log' => 'Check Admin Profile Settings Read By ' . \auth::user()->name,
        ]));
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Admins(),
            'property' => \App\Admins::find(\auth::user()->id),
            'type' => 'Read',
            'log' => 'Check Admin Profile Settings Details Read By ' . \Auth::user()->name,
        ]));
        return view('backend.profile');
    }

    public function update_profile_info(Request $request){
        $request->validate([
            'name' => 'required',
            'contact' => 'required',
        ]);
        if(\auth::user()->hasPermission('update-profile-settings')){
            \App\Admins::find(\auth::user()->id)->update($request->all());
            (new ActivityLogController())->store((new Request())->replace([
                'model' => new \App\Admins(),
                'property' => \App\Admins::find(\Auth::user()->id),
                'type' => 'Update',
                'log' => 'Update Admin Profile Settings Details Updated By ' . \Auth::user()->name,
            ]));
            return redirect()->back()->with('success',$request->input('name').", Your information has been successfully updated.");

        }else{
            abort(403);
        }
    }

    public function profile_change_password(Request $request){
        $request->validate([
            'old_password' => 'required',
            'password' => 'string|confirmed|min:8|different:old_password',
        ]);
        if(\auth::user()->hasPermission('update-profile-settings')){
            $user = \App\Admins::findOrFail(\Auth::user()->id);
            if (!Hash::check($request['old_password'], \Auth::user()->password)) {
                return redirect()->back()->with('old_password_error', 'The old password does not match our records.');
            }else{
                $user->update([
                    'password' => Hash::make($request->input('password'))
                ]);
                return redirect()->back()->with('success', $user->name. ', Your password has been successfully updated!');
            }
            \App\ActivityLog::insert([
                'log_name' => 'Update',
                'description' => 'Change Admin Profile Password. Changed By ' . \Auth::user()->name,
                'subject_type' => "App\Admins",
                'subject_id' => \Auth::user()->id,
                'causer_type' => 'App\Admins',
                'causer_id' => \Auth::user()->id,
                'properties' => \App\Admins::find(\Auth::user()->id),
            ]);
            return redirect()->back()->with('success',"Your profile password has been successfully changed.");
        }else{
            abort(403);
        }
    }
}
