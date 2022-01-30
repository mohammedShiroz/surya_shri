<?php

namespace App\Http\Middleware;

use Closure;
use App\Observers\ActivityLogObserver;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Http\Request;

class TwoFactor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \auth::guard('admin')->user();

        if(\auth::guard('admin')->check() && $user->two_factor_code)
        {
            if($user->two_factor_expires_at->lt(now()))
            {
                $user->resetTwoFactorCode();
                \auth::guard('admin')->logout();
                return redirect()->route('login')->withMessage('The two factor code has expired. Please login again.');
            }

            if(!$request->is('verify*'))
            {
                (new ActivityLogController())->store((new Request())->replace([
                    'model' => new \App\Admins(),
                    'property' => \App\Admins::find(\auth::user()->id),
                    'type' => 'Login Verification',
                    'log' => 'Admin Login Verification Code Send by ' . \auth::user()->name,
                ]));
                return redirect()->route('verify.index');
            }
        }

        return $next($request);
    }
}
