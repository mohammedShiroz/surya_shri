<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CRUDController extends Controller
{
    public function permission(Request $request)
    {
        \DB::transaction(function () use ($request) {
            if (isset($request->display_name)) {
                (new PermissionController())->store((new Request())->replace(
                    [
                        'name' => $request->name,
                        'display_name' => strtoupper($request->display_name),
                        'description' => strtoupper($request->description),
                    ]
                ));
                return back()->with('success', 'Permission has been successfully added');
            }
            if (isset($request->create)) {
                (new PermissionController())->store((new Request())->replace(
                    [
                        'name' => 'create-' . $request->name,
                        'display_name' => 'CREATE ' . strtoupper($request->name),
                        'description' => 'CREATE ' . strtoupper($request->name),
                    ]
                ));
            }

            if (isset($request->read)) {
                (new PermissionController())->store((new Request())->replace(
                    [
                        'name' => 'read-' . $request->name,
                        'display_name' => 'READ ' . strtoupper($request->name),
                        'description' => 'READ ' . strtoupper($request->name),
                    ]
                ));
            }
            if (isset($request->update)) {
                (new PermissionController())->store((new Request())->replace(
                    [
                        'name' => 'update-' . $request->name,
                        'display_name' => 'UPDATE ' . strtoupper($request->name),
                        'description' => 'UPDATE ' . strtoupper($request->name),
                    ]
                ));
            }
            if (isset($request->delete)) {
                (new PermissionController())->store((new Request())->replace(
                    [
                        'name' => 'delete-' . $request->name,
                        'display_name' => 'DELETE ' . strtoupper($request->name),
                        'description' => 'DELETE ' . strtoupper($request->name),
                    ]
                ));
            }
        });
        return back()->with('success', 'Permission CRUD has been added');
    }
}
