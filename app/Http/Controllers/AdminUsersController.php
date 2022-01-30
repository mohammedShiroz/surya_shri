<?php

namespace App\Http\Controllers;
use App\Admins;
use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;
use Illuminate\Validation\Rule;

class AdminUsersController extends Controller
{
    public function __construct()
    {
        \App\Admins::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\ActivityLog(),
            'property' => ['name' => 'Check Admin User Management List'],
            'type' => 'Read',
            'log' => 'Check Admin User Management List Read By ' . \Auth::user()->name,
        ]));
        if (\auth::user()->hasRole('super-admin') && \auth::user()->hasPermission(['read-admin'])) {
            $data = \App\Admins::all();
            return view('backend.admin_users.index', ['data' => $data]);
        }
        abort(403);
    }

    public function create()
    {
        return view('backend.admin_users.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'job_title.required' => 'The Admin Designation field is required.',
            'role_id.required' => 'The Admin Role field is required.',
        ];

        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'contact' => 'required',
            'job_title' => 'required|max:255',
        ],$messages);

        $bytes = openssl_random_pseudo_bytes(3);
        $random_pwd = bin2hex($bytes);
        $table_admin=\App\Admins::create($request->all());
        $table_admin->password = bcrypt($random_pwd);
        $table_admin->save();

        \App\RoleUsers::insert([
            'role_id' => $request->input('role_id'),
            'user_id' => $table_admin->id,
            'user_type' => 'App\Admins'
        ]);

        $user=array(
            'name' => $request->input('name'),
            'pwd' => $random_pwd,
            'email' =>$request->input('u_email'),
        );

        //:test view
        //return view('backend.emails.send_user_password',['user'=>$user]);
        $user_email = $request->input('email');
        \Mail::send('backend.emails.send_user_password', ['user'=>$user], function($message) use ($user,$user_email){
            $message->from(\App\Details::where('key','company_email')->first()->value, \config('app.name'));
            $message->to($user_email);
            $message->subject(\config('app.name').' Admin Login Credential Info');
        });
        return redirect()->back()->with('success',$request->input('name')."'s Admin User Profile has been successfully added.");
    }

    public function show($id)
    {
        return view('backend.admin_users.show',['data' => \App\Admins::find($id)]);
    }

    public function edit($id)
    {
        return view('backend.admin_users.edit',['data' => \App\Admins::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'job_title.required' => 'The Admin Designation field is required.',
        ];

        $request->validate([
            'name' => 'required|max:255',
            'email' =>  ['required','email',
                Rule::unique('admins')
                    ->wherenot('id', $id)
                    ->where('email', $request->input('email'))
            ],
            'contact' => 'required',
        ],$messages);

        \App\Admins::where('id',$id)->update($request->except('_token','_method','role_id'));
        \App\RoleUsers::where('user_id',$id)->update([
            'role_id' => $request->input('role_id'),
        ]);

        return redirect()->back()->with('success',$request->input('name')."'s Admin User Profile has been successfully updated.");
    }

    public function destroy($id)
    {
        \App\Admins::where('id',$id)->update(['deleted_at' => \Carbon\Carbon::now()]);
        return redirect()->back()->with('success',\App\Admins::find($id)->name."'s User profile has been successfully deleted.");
    }
}
