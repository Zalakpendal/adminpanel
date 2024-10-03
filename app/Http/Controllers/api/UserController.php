<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function creatUser(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => "required|string",
            'email' => "required|string|unique:users",
            'password' => "required|min:6",
        ]);
        if ($validator->fails()) {
            $result = array('status' => false, 'message' => 'validation error occured', 'error_message' => $validator->errors());
            return response()->json($result, 400);
        }
        if (isset($request->image)) {
            $image_64 = $request->image;
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.' . $extension;
            $folder = 'userimages/';
            Storage::disk('public')->put($folder . $imageName, base64_decode($image));
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $folder . $imageName,
            'is_type' => 'user'
        ]);

        if ($user->id) {
            $result = array('status' => true, 'message' => 'user created', 'data' => $user);
            $responseCode = 200;
        } else {
            $result = array('status' => false, 'message' => 'something went wrong', 'data' => $user);
            $responseCode = 400;
        }
        return response()->json($result, $responseCode);
    }
    public function getUsers()
    {
        try {
            $users = User::all();
            $result = array('status' => true, 'message' => count($users) . 'user(s) fetched', 'data' => $users);
            $responseCode = 200;
            return response()->json($result, $responseCode);
        } catch (Exception $e) {
            $result = array(
                'status' => false,
                'message' => "API failed due to an error",
                "error" => $e->getMessage()
            );
            return response()->json($result, 500);
        }

    }

    public function getUserDetail($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => "user not found"], 404);
        }
        $result = array('status' => true, 'message' => 'user found', 'data' => $user);
        $responseCode = 200;//for the 200 http request code meaning is success.
        return response()->json($result, $responseCode);

    }

    public function upateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => "user not found"], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => "required|string",
            'email' => "required|string|unique:users,email," . $id,
        ]);
        if ($validator->fails()) {
            $result = array('status' => false, 'message' => 'validation error occured', 'error_message' => $validator->errors());
            return response()->json($result, 400);//http request code 400 meaning is-- bad request.
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $result = array('status' => true, 'message' => "user has been updated successfully", 'data' => $user);
        return response()->json($result, 200);
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['status' => false, 'message' => "user not found"], 404);
        }

        $user->delete();

        $result = array('status' => true, 'message' => "user has been deleted successfully", 'data' => $user);
        return response()->json($result, 200);
    }

    public function login(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error occured',
                'error' => $validator->errors()
            ], 400);
        }

        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            ##creating a token 
            $token = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'status' => true,
                'message' => "login successful",
                "token" => $token
            ], 200);
        }
        return response()->json(['status' => false, 'message' => "invalid login credentials"], 401);
    }

    public function unauthenticated()
    {
        return response()->json(['status' => false, "message" => "only authorised user can access", "error" => "unauthenticate"], 401);
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens->each(function ($token, $key) {
        $token->delete();
        });

        return response()->json(['status' => true, 'message' => 'logged out successfully'], 200);
    }



}
