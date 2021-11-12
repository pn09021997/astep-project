<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\OauthAccessToken;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessTokenFactory;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\Token;
use Laravel\Passport\Client as OClient;
use GuzzleHttp\Client;
use Laravel\Passport\TokenRepository;


class UserController extends Controller
{
    // Login View
    public  function loginview(){
        return view('');
    }
     // Login
    public  function  login(Request  $request){
        $request->validate([
            'Username' => 'required|min:6|max:12', // khúc này ngon rồi
            'password' => 'required|min:6|max:12', // test rồi
        ]);
        $datax = [
            'Username' => $request['Username'],
            'password' => $request['password']
        ];

        if (Auth::attempt($datax))
        {
         $user =  User::where('Username',$datax['Username'])->first();
         $token = $user->createToken('user')->accessToken;
            return  response()->json(['token'=> $token],200);
        }
        else{
            return abort(401);
        }
    }





    // Register View
    public  function  registerview(){

        return view('auth.register');
    }


    // Register
    public  function  register(Request  $request)
    {
        if ($request->phone[0] != '0') {
            return  response(['error' => 'Phone always start with 0']);
        } elseif ($request->phone[0] == '0') {
            $check = $request->phone;
            for ($i = 0; $i < strlen($check); $i++) {
                if (ord($check[$i]) < 48 || ord($check[$i]) > 57) {
                    return  response(['error' => 'Please type is number in phone']);
                }
            }
        }
    $validator = Validator::make($request->all(),[
        'Username'=>'required|min:6|max:12|unique:users,Username', // khúc này ngon rồi
        'password'=>'required|min:6|max:12', // test rồi
        'email' => 'required|email|unique:users,email', // test luôn rồi
        'phone'=>'required|digits:10|unique:users,phone', // khúc này test luôn rồi
    ]);

        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $data = [
            'Username' => $request['Username'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'type' => 0
        ];
        DB::table('users')->insert($data);
        return response()->json([
            'status' => "Sign Up Success"
        ], 200);
    }



     // Get  info user
    public  function  infoview(Request $request){
        $data = Auth::user();
        $datatoClient = [
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ];
        return response()->json($datatoClient);
    }

    // Update Info User
    public  function  infoPost(Request  $request){
        $checkrule = array() ;
        $data = Auth::user();
        if ($data['email'] != $request->old_email || $data['phone'] != $request->old_phone
            || $data ['address'] != $request->old_address){
            return response(['error' => 'Not Update Success']);
        }
        $phone = $request->phone;
        if ($data['email'] != $request->email) {
            $email = ['email' => 'required|email|unique:users,email'];
            $checkrule['email'] = $email;
        }
        if ($data['phone'] != $phone) {
            if ($phone[0] != '0') {
                return  response(['error' => 'Phone always start with 0']);
            } elseif ($phone[0] == '0') {
                $check = $phone;
                for ($i = 0; $i < strlen($check); $i++) {
                    if (ord($check[$i]) < 48 || ord($check[$i]) > 57) {
                        return  response(['error' => 'Please type is number in phone']);
                    }
                }
            }
            $phone = ['phone' => 'required|digits:10|unique:users,phone'];
            $checkrule['phone'] = $phone;
        }
        foreach ($checkrule as $x) {
            $validator = Validator::make($request->all(), $x);
            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 422);
            }
        }
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data->save();
        return  response()->json(['status' => 'Update Success'], 200);
    }

    // Update PassWord
    public  function  PasswordUpdate(Request  $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:6|max:12', 
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'Update password fail']);
        }
        $data = Auth::user();
        $old_password = $request->old_password;
        if (!Hash::check($old_password, $data['password'])) {
            return response()->json(['status' => 'old password is wrong ']);
        }
        $data['password'] = bcrypt($request['new_password']);
        $data->save();
        return response()->json(['status' => 'Update Success', 'password' => $data], 200);
    }

    // Logout
    public function  UserLogout(Request  $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Token::where('user_id', $user->id)
                ->update(['revoked' => true]);
            return response()->json(['status' => 'logout success'], 200);
        }
    }
}
