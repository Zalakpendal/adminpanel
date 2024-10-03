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
    public function index(Request $request)
    {
        $currentUser = Auth::user();

        if ($currentUser->is_type == 'admin') {

            $search = $request->input('search');
            $query = User::sortable()->where('is_type', 'admin') ->whereHas('roles', function ($query) {
                $query->whereIn('name', ['admin', 'chef']);
            })
            ->with('restaurant') 
            ->orderBy('created_at', 'desc');

           
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('restaurant', function ($q) use ($search) {
                        $q->where('restaurantname', 'like', "%{$search}%");
                    });
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
        $roles = Role::whereIn('name', ['admin', 'chef'])->pluck('name', 'name')->all();
        return view('role-permission.user.create', ['roles' => $roles, 'restaurants' => $restaurants]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:admins,email',
            'password' => 'required|min:6',
            'roles' => 'required',
        ],['name.required' => 'Please enter your username.',
                    'roles.required'=> 'Please select any role']);
        $user = new User();
        $user->restaurants = $request->restaurants;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_type = "admin";
        // $user->roles_id = $request->roles;
        $user->roles_id = json_encode($request->roles);
        $user->save();
        $user->syncRoles($request->roles);

        return redirect('/users')->with('success', 'user created successfully with roles');
    }

    public function edit(User $user)
    {
        $roles = Role::whereIn('name', ['admin', 'chef'])->pluck('name', 'name')->all(); 
        $userRoles = $user->roles()->whereIn('name', ['admin', 'chef'])->pluck('name', 'name')->all(); 
        $restaurants = restaurantslist::pluck('restaurantname', 'id');

        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'restaurants' => $restaurants,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email',
            'roles' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'roles' => json_encode($request->roles),
        ];
        $user->restaurants = $request->restaurants;
        $user->roles_id = json_encode($request->roles);
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

    public function editprofile()
    {
        $user = Auth::user();
        return view('admin.profile.editprofile', ['user' => $user]);
    }

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
            $imageName = time() . '_' . $user->id . '.' . $request->image->extension();
            $path = $request->file('image')->storeAs($filePath, $imageName, 'public');
            $user->image = $path;
        }

        $user->save();
        return redirect()->route('admin.dashbord')->with('success', 'Profile updated successfully.');
    }
 

    public function showChangePasswordForm()
    {
        return view('admin.profile.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('admin.dashbord')->with('success', 'Password changed successfully.');
    }

}




