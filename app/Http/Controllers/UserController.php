<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    //
    public function register(Request $request){
        $validate = $request->validate([
            'email'=>['required','email','unique:users'],
            'password'=>['required','min:6'],
        ]);
        if($validate){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 0;
            $user->approve = 0;
            $user->save();
            return redirect()->route('user_login.get')->with('message','Registration is successfull');
        }
            return back()->withErrors([
                'user'=> 'User Already Exists!'
            ]);


    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>['required'],
            'password'=>['required','min:6'],
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return  redirect()->route('user.dashboard');

        }
        return back()->withErrors([
            'email'=> 'The provided credentials do not match our records.'
        ]);
    }

    public function redirectDash(){
            if(Auth::user()){
                return view('app');
            }else{
                return view('welcome');
            }
    }

    public function logout(){
        session()->flush();
        Auth::logout();
        return $this->redirectDash();
    }
}
