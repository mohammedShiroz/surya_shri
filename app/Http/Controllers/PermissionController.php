<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observers\ActivityLogObserver;
use App\Permission;
use Illuminate\Support\Facades\Auth;


class PermissionController extends Controller
{
    public function __construct()
    {
        Permission::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        if (\auth::user()->hasPermission('read-permission')) {
            return view('backend.admin_users.permission.index', ['data' => Permission::all()]);
        }
        abort(403);
    }

    public function create()
    {
        if (\auth::user()->hasPermission('create-permission')) {
            return view('backend.admin_users.permission.create');
        }
        abort(403);
    }

    public function store(Request $request)
    {
        if (\auth::user()->hasPermission('create-permission')) {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:permissions',
                'display_name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
            $this->saveToDB(new Permission(), $request)->save();
            return back()->with('success', 'Permission ' . $request->input('name') . ' has been successfully added.');
        }
        abort(403);
    }

    public function show($id)
    {
        if (\auth::user()->hasPermission('read-permission')) {
            return view('backend.admin_users.permission.show', ['data' => Permission::findOrFail(HashDecode($id))]);
        }
        abort(403);
    }

    public function edit($id)
    {
        return view('backend.admin_users.permission.edit',['data' => Permission::find(HashDecode($id))]);
    }

    public function update(Request $request, $id)
    {
        if (\auth::user()->hasPermission('update-permission')) {
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:permissions,name,' . HashDecode($id),
                'display_name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);
            $this->saveToDB(Permission::findOrFail(HashDecode($id)), $request)->update();
            return back()->with('success', 'Permission ' . $request->name . ' Updated');
        }
        abort(403);
    }

    public function destroy($id)
    {
        if (\auth::user()->hasPermission('delete-permission')) {
            Permission::destroy(HashDecode($id));
            return redirect(route('permission.index'))->with('success', 'Permission Deleted');
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
