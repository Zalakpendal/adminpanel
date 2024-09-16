<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create role', ['only' => ['create', 'store', 'addpermissionToRole', 'givepermissionToRole']]);
        $this->middleware('permission:update role', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete role', ['only' => ['destory']]);
        $this->middleware('permission:view role', ['only' => ['index']]);
    }
    // public function index()
    // {

    //     $roles = Role::paginate(5);
    //     return view('role-permission.role.index', ['roles' => $roles]);
    // }
    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $roles = $query->paginate(5);

        return view('role-permission.role.index', [
            'roles' => $roles
        ]);
    }
    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'unique:roles,name'
                ]
            ]
        );

        Role::create([
            'name' => $request->name
        ]);
        return redirect('role')->with('success', 'Role Created Successfully');

    }
    public function edit(Role $role)
    {
        // return $permission;
        return view('role-permission.role.edit', ['role' => $role]);
    }
    public function update(Request $request, Role $role)
    {

        $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'unique:roles,name,' . $role->id
                ]
            ]
        );

        $role->update([
            'name' => $request->name
        ]);
        return redirect('role')->with('success', 'Role updated Successfully');


    }
    public function destory($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect('role')->with('success', 'Role deleted Successfully');
    }

    public function addpermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::find($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();


        return view('role-permission.role.add-permission', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givepermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('success', 'Permission added');
    }

}