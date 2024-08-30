<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('permission:create permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:update permission', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete permission', ['only' => ['destory']]);
        $this->middleware('permission:view permission', ['only' => ['index']]);
    }
    
    public function index()
    {
        $permissions = Permission::paginate(5);
        return view('role-permission.permission.index', ['permissions' => $permissions]);
    }
    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'unique:permissions,name'
                ]
            ]
        );

        Permission::create([
            'name' => $request->name
        ]);
        return redirect('permission')->with('status', 'Permission Created Successfully');

    }
    public function edit(Permission $permission)
    {
        // return $permission;
        return view('role-permission.permission.edit', ['permission' => $permission]);
    }
    public function update(Request $request, Permission $permission)
    {

        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'unique:permissions,name,' . $permission->id
                ]
            ]
        );

        $permission->update([
            'name' => $request->name
        ]);
        return redirect('permission')->with('status', 'Permission updated Successfully');


    }
    public function destory($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        return redirect('permission')->with('status', 'Permission deleted Successfully');
    }
}
