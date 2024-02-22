<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Stripe;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon;
class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        $validate = $request->validate([
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);
        if ($validate) {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 0;
            $user->approve = 0;
            $user->save();
            return redirect()->route('user_login.get')->with('message', 'Registration is successfull');
        }
        return back()->withErrors([
            'user' => 'User Already Exists!'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required', 'min:6'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return  redirect()->route('user.dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    public function redirectDash()
    {
        if (Auth::user()) {
            $package = DB::table('packages')->get();
            return view('app', ['packages' => $package]);
        } else {
            return view('welcome');
        }
    }

    public function checkout(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $userPackageData= array();
        $userPackageData['id'] = $request->user_id;
        $userPackageData['username'] = $request->user_name;
        $userPackageData['email'] = $request->email;
        $userPackageData['package_name'] = $request->package_name;
        $userPackageData['package_price'] = $request->package_price;
        $userPackageData['packge_role'] = $request->package_role;


        $session = \Stripe\Checkout\Session::create([
            'line_items'  => [
                [
                    'price_data' => [
                        'currency'     => 'USD',
                        'product_data' => [
                            "name" => $request->package_name,
                        ],
                        'unit_amount'  => $request->package_price,
                    ],
                    'quantity'   => 1,
                ],
                 
            ],
            'mode'        => 'payment',
            'success_url' => route('success', ['userData' => base64_encode(serialize($userPackageData))]),
            'cancel_url'  => route('user.dashboard'),
        ]);
 
        return redirect()->away($session->url);

    }

    public function success(Request $request)
    {
      
        $input = $request->input('userData');
        $decode = base64_decode($input);
        $userData = unserialize($decode);
        $user = array();
        $id = $userData['id'];
        $user['user_package_name'] = $userData['package_name'];
        $user['user_package_role'] = $userData['packge_role'];
        $user['user_package_purchase'] = 1;
        DB::table('users')->where('id',$id)->update(['user_package_name'=>$user['user_package_name'],'user_package_role'=>$user['user_package_role'],'user_package_purchase'=>$user['user_package_purchase']]);
        return redirect()->route('user.dashboard')->with('purchased','Package Purchased Successfully');
        // return "Thanks for you order You have just completed your payment. The seeler will reach out to you as soon as possible";
    }

    public function profile_details(Request $request){
        $user_details = new UserDetails;
        $user_details->user_id = $request->user_id;
        $user_details->bank_account = $request->bank_account;
        $user_details->card_no = $request->card_no;
        $user_details->phone = $request->phone;
        $user_details->contact = $request->contact;

        if($request->hasFile('nid')){
            $nid = $request->file('nid');
            $random = hexdec(uniqid());
            $ext = strtolower($nid->getClientOriginalExtension());
            $imgName = $random.".".$ext;
            $path = 'img/';
            $pathImage = $path.$imgName;
            $nid->move($path,$imgName);
            $user_details->nid  = $pathImage;
        }else{
            $user_details->nid  = "";
        }
        if($request->hasFile('passport')){
            $passport = $request->file('passport');
            $random = hexdec(uniqid());
            $ext = strtolower($passport->getClientOriginalExtension());
            $imgName = $random.".".$ext;
            $path = 'img/';
            $pathImage = $path.$imgName;
            $passport->move($path,$imgName);
            $user_details->passport  = $pathImage;
        }else{
            $user_details->nid  = "";
        }
        $user_details->save();
        return redirect()->route('user_details_info');
    }

    public function user_details_info(){
        $user = Auth::user();
        $userDetails = UserDetails::find($user->id);
        $userData = array();
        $userData['user_id'] = $user->id;
        $userData['bank_account']= $userDetails->bank_account;
        $userData['card_no']= $userDetails->card_no;
        $userData['phone']= $userDetails->phone;
        $userData['contact']= $userDetails->contact;
        $userData['nid']= $userDetails->nid;
        $userData['passport']= $userDetails->passport;

        return view('pages.user_details',['data'=>$userData]);
    }


    public function logout()
    {
        session()->flush();
        Auth::logout();
        return $this->redirectDash();
    }
}
