<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create user', ['only' => ['create','store']]);
        $this->middleware('permission:update user', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete user', ['only' => ['destory']]);
        $this->middleware('permission:view user', ['only' => ['index']]);
    }
    // public function index()
    // {
    //     $users = User::all();
    //     // $admin = DB::table('admins')->get(); // This is correct
    //     $roles = role::pluck('name');
    //     return view('role-permission.user.index', [
    //         'users' => $users,
    //         'roles' => $roles,
    //     ]);
    // }
    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->is_type == 'admin') {
            
            $users = User::sortable()->where('is_type', 'admin')->paginate(5);
        } else {
            return redirect('/')->withErrors('You are not authorized to view this page.');
        }

        $roles = Role::pluck('name', 'name');
        return view('role-permission.user.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('role-permission.user.create', ['roles' => $roles]);
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required',
            'roles' => 'required'
        ]);
        // $user = User::create([
        //     'name' => $request->name,
        //     'email'=> $request->email,
        //     'password'=>Hash::make($request->password),
        //     $user->is_type="admin";
        // ]);
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->is_type="admin";
        $user->save();
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status','user created successfully with roles');

    }
    public function edit(User $user)
    {
        // return $user;
        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();
        return view('role-permission.user.edit',['user'=> $user,
        'roles'=> $roles,
        'userRoles' =>$userRoles]);

    }

    public function update(Request $request,User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required',
            'roles' => 'required'
        ]);

        $data = [
            'name'=> $request->name,
            'email'=> $request ->email,
            'password'=> Hash::make($request->password),
        ];
        if(!empty($request->password))
        {
            $data += [
                'password'=> Hash::make($request->password),
            ];
        }
        $user->update($data);
        $user->syncRoles($request->roles);
        return redirect('/users')->with('status','user updated successfully with roles');
    }
    public function destroy($userId)
    {
        $user =  User::findOrFail($userId);
        $user->delete();
        return redirect('/users')->with('status','user deleted successfully with roles');
    }



}





