<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
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
            $user->role = 1;
            $user->approve = 1;

            $user->save();
            return redirect()->route('admin_login.get')->with('message','Registration is successfull');
        }
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email'=>['required'],
            'password'=>['required','min:6'],
        ]);
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors([
            'email'=> 'The provided credentials do not match our records.'
        ]);
    }
    public function redirectDash(){
        if(Auth::user()){
            return view('app');
        }else{
            return view('home');
        }
    }

    public function management(){
        $users = DB::table('users')->where('role',0)->where('approve',0)->get();
        return view('pages.user_management',['users'=>$users]);
    }

    public function approve(User $user){
        $id = $user->id;
        $approve =DB::table('users')->where('id',$id)->update(['approve'=>1]);
        return back()->with('approved','The user is successfully approved');
    }
}
