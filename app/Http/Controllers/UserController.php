<?php

namespace App\Http\Controllers;

use App\Models\Restaurants\restaurantslist;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
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
    // public function index()
    // {
    //     $currentUser = Auth::user();

    //     if ($currentUser->is_type == 'admin') {

    //         $users = User::sortable()->where('is_type', 'admin')->paginate(5);
    //     } else {
    //         return redirect('/')->withErrors('You are not authorized to view this page.');
    //     }

    //     $roles = Role::pluck('name', 'name');
    //     return view('role-permission.user.index', [
    //         'users' => $users,
    //         'roles' => $roles,
    //     ]);
    // }
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        if ($currentUser->is_type == 'admin') {

            $search = $request->input('search');
            $query = User::sortable()->where('is_type', 'admin');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            }
            $users = $query->paginate(3);

            return view('role-permission.user.index', [
                'users' => $users,
                'search' => $search,
            ]);
        } else {
            return redirect('/')->withErrors('You are not authorized to view this page.');
        }
    }


    public function create()
    {
        $restaurants = restaurantslist::pluck('restaurantname', 'id');
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', ['roles' => $roles,'restaurants'=>$restaurants]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required',
            'roles' => 'required',
            'restaurants' => 'required'
        ]);
        // $user = User::create([
        //     'name' => $request->name,
        //     'email'=> $request->email,
        //     'password'=>Hash::make($request->password),
        //     $user->is_type="admin";
        // ]);
        $user = new User();
        $user->restaurants = $request->restaurants;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_type = "admin";
        $user->save();
        $user->syncRoles($request->roles);

        return redirect('/users')->with('success', 'user created successfully with roles');

    }
    public function edit(User $user)
    {
        // return $user;
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);

    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'password' => 'required',
            'roles' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];
        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->password),
            ];
        }
        $user->update($data);
        $user->syncRoles($request->roles);
        return redirect('/users')->with('success', 'user updated successfully with roles');
    }
    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect('/users')->with('success', 'user deleted successfully with roles');
    }


    //complete code 


    public function editprofile()
    {
        $user = Auth::user();
        return view('admin.profile.editprofile', ['user' => $user]);
    }

    // public function updateProfile(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'profilepicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate file
    //     ]);
    

    //     $user = Auth::user();
    //     $user->name = $request->name;
        
    //     if ($request->file('image')) {
    //         $filePath = 'userprofileimages';
    //         $path = Storage::disk('public')->put($filePath, $request->image);
    //         $user->image = $path;
    //         $user->save();
    //         return redirect()->route('admin.dashbord')->with('status', 'Profile updated successfully.');
    //     }
    // }
    public function updateProfile(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
    ]);

    $user = Auth::user();
    $user->name = $request->name;

    if ($request->hasFile('image')) {
        $filePath = 'userprofileimages';

        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }
        $imageName = $request->image->extension();
        $path = $request->file('image')->storeAs($filePath, $imageName, 'public');
        $user->image = $path;
    }

    $user->save();
    return redirect()->route('admin.dashbord')->with('success', 'Profile updated successfully.');
}



}





