<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;
use App\Admins;

class LaratrustController extends Controller
{
    public function userPermission(Request $request)
    {
        if (\auth::user()->hasPermission('acl')) {
            if ($request->type === 'attach')
                Admins::findOrFail(HashDecode($request->user_id))->attachPermission(HashDecode($request->permission_id));
            else
                Admins::findOrFail(HashDecode($request->user_id))->detachPermission(HashDecode($request->permission_id));
            return back()->with('success', 'Permission ' . $request->type . 'ed ');
        }
        abort(403);
    }

    public function userRole(Request $request)
    {
        if (\auth::user()->hasPermission('acl')) {
            if ($request->type === 'attach')
                Admins::findOrFail(HashDecode($request->user_id))->attachRole(HashDecode($request->role_id));
            else
                Admins::findOrFail(HashDecode($request->user_id))->detachRole(HashDecode($request->role_id));
            return back()->with('success', 'Role ' . $request->type . 'ed ');
        }
        abort(403);
    }

    public function rolePermission(Request $request)
    {
        if (\auth::user()->hasPermission('acl')) {
            if ($request->type === 'attach')
                Role::findOrFail(HashDecode($request->role_id))->attachPermission(HashDecode($request->permission_id));
            else
                Role::findOrFail(HashDecode($request->role_id))->detachPermission(HashDecode($request->permission_id));
            return back()->with('success', 'Permission ' . $request->type . 'ed ');
        }
        abort(403);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
