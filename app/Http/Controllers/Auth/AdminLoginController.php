<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Notifications\TwoFactorCode;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Auth;
use App\Observers\ActivityLogObserver;
use App\Http\Controllers\ActivityLogController;

class AdminLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware(['guest:admin','two_factor'],['except' => ['logout']]);
    }

    public function show_login_form()
    {
        return view('backend.auth.login')->with(['page_title'=>"Admin Login"]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
        ]);

        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|min:6'
        ]);
    }

    public function username()
    {
        return 'email';
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('admin.dashboard')->with('welcome_msg','success');
    }

    protected function authenticated(Request $request, $user)
    {
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
//        throw ValidationException::withMessages([
//            $this->username() => [trans('auth.failed')],
//        ]);
        return redirect()->back()->withInput($request->only('email', 'remember'))->withError('These credentials do not match our records.');
    }

    public function logout(Request $request)
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Admins(),
            'property' => \App\Admins::find(\Auth::user()->id),
            'type' => 'Logout',
            'log' => 'Admin Logout. by ' . \Auth::user()->name,
        ]));
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('admin.login');

    }

    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
//        return redirect()->route('admin.login')->withInput($request->only('email', 'remember'))->withError('Too many attempts tried. Please try again latter.');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
