<?php

namespace App\Http\Controllers;


use Auth;
use Illuminate\Http\Request;

class adminController extends Controller
{
    public function showForm()
    {
        return view('loginform');
    }
    public function checklogin(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'email'=> 'required',
            'password'=> 'required',
        ]);

        // if(Auth::attempt(['email' => $input['email'],'password' => $input['password']]))
        // {
        //     return redirect()->route('admin.dashbord');
        // }
        // else{
        //     // dd('incorrect');
        //     return redirect()->route('showForm');
        // }
        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $user = Auth::user();
            if ($user->is_type == 'admin') {
                return redirect()->route('admin.dashbord');
            }
             else {
                return redirect()->back(); 
            }
        } else {
            return redirect()->route('showForm')->withErrors('Invalid email or password.');
        }
    
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('showForm');
    }
    

    public function dashbord(){
        $user = Auth::user();
        return view('admin/admindashbord');
    }
}

