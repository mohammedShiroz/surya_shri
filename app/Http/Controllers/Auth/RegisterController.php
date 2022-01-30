<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\NewUser;
use App\Notifications\NewUserNotification;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Config;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail,Redirect,Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'register_user' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'user_code'=> 'null',
            'gender'=> 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $table =User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'user_code'=> substr(md5(mt_rand()), 0, 7),
            'contact' => $data['contact'],
            'email' => $data['email'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
        ]);
        if(isset($data['newsletter'])){
            $table->e_subscribe = 1;
        }
        if(isset($data['is_invited'])){
            $table->is_invited = $data["is_invited"];
        }
        if(isset($data["become_partner"]) && $data["referral"]){
            $table->request_referral = $data["referral"];
            $table->agent_status = "Requested";
            $table->agent_request_date = Carbon::now();
        }
        $table->save();
        if($data['register_user'] !="new_user") {
            $user_id=User::orderby('created_at','DESC')->firstOrfail()->id;
            //:record invited friends count
            \App\Emp_friends_invite::create([
                'agent_id' => $data['register_user'],
                'user_id' => $user_id,
            ]);
        }
        return $table;
    }


    public function register(Request $request) {
        $input = $request->all();
        $validator = $this->validator($input);
        if ($validator->passes()){
            $user = $this->create($input)->toArray();
            $user['link'] = Str::random(30);
            $user_email=$request->email;
            \App\Users_activation::insert(['user_id'=>$user['id'],'token'=>$user['link']]);
            \Mail::send('emails.activation', $user, function($message) use ($user,$user_email){
                $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
                $message->to($user_email);
                $message->subject(\config('app.name').' Email Verification');
            });

            $user_info=\App\User::find($user['id']);
            \App\ActivityLog::create([
                'log_name' => 'Register',
                'description' => 'User Registration. registered by ' . $user['name'],
                'subject_type' => "App\User",
                'subject_id' => $user['id'],
                'causer_type' => 'App\User',
                'causer_id' => $user['id'],
                'properties' => \App\User::find($user['id']),
            ])->notify(new NewUser($user_info));

            $success_msg="Hey ".$request->name." ".$request->last_name.". we've sent the activation link to your email. Please check your mail and verify your account.";
            return redirect()->to('login')->with('success',$success_msg);
        }
        return back()->withInput()->withErrors($validator)->with('errors',$validator->errors());
    }

    public function resend_link($id){
        if(\App\Users_activation::where('user_id',$id)->first()){
            \App\Users_activation::where('user_id',$id)->delete();
        }

        $user = \App\User::find($id)->toArray();
        $user_email = $user["email"];
        $user['link'] = Str::random(30);
        \App\Users_activation::insert(['user_id'=>$id,'token'=>$user['link']]);
        \Mail::send('emails.activation', $user, function($message) use ($user,$user_email){
            $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
            $message->to($user_email);
            $message->subject(\config('app.name').' Email Verification');
        });

        \App\ActivityLog::create([
            'log_name' => 'Register',
            'description' => 'User resent action code. resend by ' . $user['name'],
            'subject_type' => "App\User",
            'subject_id' => $user['id'],
            'causer_type' => 'App\User',
            'causer_id' => $user['id'],
            'properties' => \App\User::find($user['id']),
        ]);

        return redirect()->back()->with('success','Verification link has been resend to your email. Check and verify your account.');
    }

    public function userActivation($token){
        $check = \App\Users_activation::where('token',$token)->first();
        if($check){
            $user = User::where('id',$check->user_id)->first();
            $user->where('id', $check->user_id)->update(['email_verified_at' => Carbon::now()->toDateTimeString()]);
            \App\Users_activation::where('token',$token)->delete();
            if($user->agent_status == "Requested"){
                \App\Agent::create([
                    'user_id' => $check->user_id,
                    'ref_id' => $user->request_referral,
                    'intro_id' => $user->request_referral,
                    'placement_id' => $user->request_referral,
                ]);
                if($user->is_invited){
                    //:record invited friends count
                    \App\Emp_friends_invite::create([
                        'agent_id' => $user->request_referral,
                        'user_id' => $user->id,
                    ]);
                }
                \App\User::where('id', $user->id)->update(['agent_status' => 'Approved','agent_id' => \App\Agent::where('user_id',$user->id)->first()->id]);
                \Session::flash('partner_approved_success', "<strong>Congratulation</strong> ".$user->name.". Your partnership request has been approved.");
                \App\ActivityLog::create([
                    'log_name' => 'Register',
                    'description' => 'User Account Activation. activated by ' . $user->name,
                    'subject_type' => "App\User",
                    'subject_id' => $user->id,
                    'causer_type' => 'App\User',
                    'causer_id' => $user->id,
                    'properties' => \App\User::find($user->id),
                ]);
                return redirect()->to('login')->with('success',"your account has been activated.");
            }else{

                \App\ActivityLog::create([
                    'log_name' => 'Register',
                    'description' => 'User Account Activation. activated by ' . $user->name,
                    'subject_type' => "App\User",
                    'subject_id' => $user->id,
                    'causer_type' => 'App\User',
                    'causer_id' => $user->id,
                    'properties' => \App\User::find($user->id),
                ]);
                return redirect()->to('login')->with('success',"Congratulation ".$user->name.". your account has been activated.");
            }
        }else{
            return redirect()->to('login')->with('Warning',"Opps! your token is invalid");
        }
    }

}
