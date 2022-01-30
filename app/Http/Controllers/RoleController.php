<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;
use App\Permission;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function __construct()
    {
        Role::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        if (\auth::user()->hasPermission(['read-role', 'read-roles'])) {
            return view('backend.admin_users.role.index', ['data' => Role::all()]);
        }
        abort(403);
    }

    public function create()
    {
        if (\auth::user()->hasPermission(['create-role', 'create-roles'])) {
            return view('backend.admin_users.role.create');
        }
        abort(403);
    }

    public function store(Request $request)
    {
        if (\auth::user()->hasPermission(['create-role', 'create-roles'])) {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:roles',
                'display_name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
            $this->saveToDB(new Role(), $request)->save();
            return back()->with('success', 'Role ' . $request->name . ' has been successfully added.');
        }
        abort(403);
    }

    public function show($id)
    {
        if (\auth::user()->hasPermission(['read-role', 'read-roles'])) {
            return view('backend.admin_users.role.show', [
                'data' => Role::findOrFail(HashDecode($id)),
                'permissions' => Permission::all()
            ]);
        }
        abort(403);
    }

    public function edit($id)
    {
        return view('backend.admin_users.role.edit',['data' => Role::find(HashDecode($id))]);
    }

    public function update(Request $request, $id)
    {
        if (\auth::user()->hasPermission(['update-role', 'update-roles'])) {
            $this->validate($request, [
                'name' =>  ['required','string','max:255',
                    Rule::unique('roles')
                        ->wherenot('id', HashDecode($id))
                        ->where('name', $request->input('name'))
                ],
                'display_name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
            $this->saveToDB(Role::findOrFail(HashDecode($id)), $request)->update();
            return back()->with('success', 'Role ' . $request->name . ' Updated');
        }
        abort(403);
    }

    public function destroy($id)
    {
        if (\auth::user()->hasPermission(['delete-role', 'delete-roles'])) {
            Role::destroy(HashDecode($id));
            return redirect(route('role.index'))->with('success', 'Role Deleted');
        }
        abort(403);
    }

    private function saveToDB($table, $request)
    {
        $table->name = $request->name;
        $table->display_name = $request->display_name;
        $table->description = $request->description;
        return $table;
    }
}
