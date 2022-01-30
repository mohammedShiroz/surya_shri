<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\NewLogin;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['two_factor']);
    }

    public function index()
    {
        return view('backend.auth.twoFactor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required',
        ]);
        $user = \auth::guard('admin')->user();
        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            $user->resetTwoFactorCode();
            \App\ActivityLog::create([
                'log_name' => 'Login',
                'description' => 'Admin Login. Access by ' . \Auth::guard('admin')->user()->name,
                'subject_type' => "App\Admins",
                'subject_id' => \Auth::guard('admin')->user()->id,
                'causer_type' => 'App\Admins',
                'causer_id' => \Auth::guard('admin')->user()->id,
                'properties' => \App\Admins::find(\Auth::guard('admin')->user()->id),
            ]);

            \App\Admins::find(\Auth::guard('admin')->user()->id)->notify(new NewLogin(\App\Admins::find(\Auth::guard('admin')->user()->id)));
            return redirect()->route('admin.home')->with('welcome_msg','success');
        }
        return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code you have entered does not match']);
    }

    public function resend()
    {
        $user = \auth::guard('admin')->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Admins(),
            'property' => \App\Admins::find(\Auth::guard('admin')->user()->id),
            'type' => 'Login Verification Resend',
            'log' => 'Admin Login Verification Code Resend by ' . \Auth::guard('admin')->user()->name,
        ]));
        return redirect()->back()->withMessage('The two factor code has been sent again');
    }
}
