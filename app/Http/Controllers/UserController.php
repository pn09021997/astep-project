<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\review;
use App\Models\User;
use App\Models\user_cart;
use App\Models\users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
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



// Tuấn User Controller
class UserController extends Controller
{
    // Login View
    public  function loginview()
    {
        return view('');
    }
    // Login
    public  function  login(Request  $request)
    {
        $request->validate([
            'Username' => 'required|min:6|max:12', // khúc này ngon rồi
            'password' => 'required|min:6|max:12', // test rồi
        ]);
        $datax = [
            'Username' => $request['Username'],
            'password' => $request['password']
        ];

        //Note check username !== db || password !== db
        if (Auth::attempt($datax)) {
            if (Auth::user()->is_verify != 1) {
                return response()->json(["status" => 'Please Check your email to verify account']);
            }
            $user =  User::where('Username', $datax['Username'])->first();
            $token = $user->createToken('user')->accessToken;
            return  response()->json(['token' => $token, 'role' => $user["type"]], 200);
        } else {
            return response(['errors' => "User not exist !"]);
        }
    }





    // Register View
    public  function  registerview()
    {

        return response(['verifySuccess' => 'verify successfully!!!']);
    }


    // Register
    public  function  register(Request  $request)
    {
        if ($request->phone[0] != '0') {
            return  response(['errors' => 'Phone always start with 0']);
        } elseif ($request->phone[0] == '0') {
            $check = $request->phone;
            for ($i = 0; $i < strlen($check); $i++) {
                if (ord($check[$i]) < 48 || ord($check[$i]) > 57) {
                    return  response(['errors' => 'Please type is number in phone']);
                }
            }
        }
        $validator = Validator::make($request->all(), [
            'Username' => 'required|min:6|max:12|unique:users,Username', // khúc này ngon rồi
            'password' => 'required|min:6|max:12', // test rồi
            'email' => 'required|email|unique:users,email', // test luôn rồi
            'phone' => 'required|digits:10|unique:users,phone', // khúc này test luôn rồi
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $data = [
            'Username' => $request['Username'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => Hash::make($request['password']),
            'type' => 0,
            'verify_code' => sha1(time()),
            'is_verify' => 1,
        ];
        DB::table('users')->insert($data);
        MailController::SendMailRegister($data['email'], $data['verify_code']);
        return response()->json([
            'status' => "Sign Up Success"
        ], 200);
    }



    // Get  info user
    public  function  infoview(Request $request)
    {
        $data = Auth::user();
        $datatoClient = [
            'username' => $data['Username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ];
        return response()->json($datatoClient);
    }

    // Update Info User
    public  function  infoPost(Request  $request)
    {
        $checkrule = array();
        $data = Auth::user();
        /*if ($data['email'] != $request->old_email || $data['phone'] != $request->old_phone
            || $data ['address'] != $request->old_address){
            return response(['error' => 'Not Update Success']);
        }*/
        $phone = $request->phone;
        if ($data['email'] != $request->email) {
            $email = ['email' => 'required|email|unique:users,email'];
            $checkrule['email'] = $email;
        }
        if ($data['phone'] != $phone) {
            if ($phone[0] != '0') {
                return  response(['errors' => 'Phone always start with 0']);
            } elseif ($phone[0] == '0') {
                $check = $phone;
                for ($i = 0; $i < strlen($check); $i++) {
                    if (ord($check[$i]) < 48 || ord($check[$i]) > 57) {
                        return  response(['errors' => 'Please type is number in phone']);
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
    public  function  UserVerifyEmail(Request $request)
    {
        return response(["message" => "Your Verify code is wrong !!!"]);
        $verify_code =  $request->query('code');
        $user = User::where('verify_code', '=', $verify_code)->first();
        if ($user == null) {

            return response(["message" => "Your Verify code is wrong !!!"]);
        } else {
            dd($user['is_verify']);
            $user['is_verify'] = 1;
            $user->save();
            return view('welcome', ['path' => "assets/Login.js"]);
        }
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = users::all()->toArray();
        $return = [];
        foreach ($users as $item) {
            $item['id'] = $this->Xulyid($item['id']);
            $return[] = $item;
        }
        return response()->json($return);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Username' => 'required|min:6|max:12|unique:users,Username',
            'password' => 'required|min:6|max:12',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|unique:users,phone',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        if ($request->type == null) {
            $type = 0;
        } else {
            $type = $request->type;
        }

        $user = new users([
            'Username' => $request->get('Username'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => Hash::make($request['password']),
            'type' => $type,
            'address' => $request->get('address'),
        ]);

        $user->save();
        return response()->json([
            'message' => 'user created',
            'users' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user_id = $this->DichId($id);
        $user = users::find($user_id);
        if ($user) {
            return response()->json([
                'message' => 'user found!',
                'users' => $user,
            ]);
        }
        return response()->json([
            'message' => 'user not found!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $list = users::all()->toArray();
        $return = [];
        foreach ($list as $item) {
            $item['id'] = $this->Xulyid($item['id']);
            $return[] = $item;
        }

        $user_id = $this->DichId($id);
        $user = users::find($user_id);

        if ($user) {


            $validator = Validator::make($request->all(), [
                'Username' => 'required|min:6|',
                'password' => 'required|min:6|max:12',
                'email' => 'required|email|',
                'phone' => 'required|digits:10|',
            ]);

            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 422);
            }

            if ($user['email'] != $request->old_email) {
                return response(['message' => 'Update failed']);
            }

            if ($request->type == null) {
                $type = 0;
            } else {
                $type = $request->type;
            }

            //Kiem tra username da co hay chua, co bi trung khong
            if ($request->Username == $list[0]['Username']) {
                return response()->json([
                    'message' => 'The username has been exits!!!',
                ]);
            } else {
                $Username = $request->Username;
            }

            //Kiem tra email da co hay chua, co bi trung khong
            if ($request->email == $list[0]['email']) {
                return response()->json([
                    'message' => 'The email has been exits!!!',
                ]);
            } else {
                $email = $request->email;
            }

            //Kiem tra phone da co hay chua, co bi trung khong
            if ($request->phone == $list[0]['phone']) {
                return response()->json([
                    'message' => 'The phone has been exits!!!',
                ]);
            } else {
                $phone = $request->phone;
            }



            $user->update([
                $user->Username = $Username,
                $user->email = $email,
                $user->phone = $request->get('phone'),
                $user->password = Hash::make($request['password']),
                $user->type = $type,
                $user->address = $request->get('address')
            ]);
            $user->save();
            return response()->json([
                'message' => 'user updated!',
                'user' => $user
            ]);
        }

        return response()->json([
            'message' => 'user not found!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = $this->DichId($id);
        $flag = true;
        $user = users::find($id);
        if ($user) {

            $userCartListTemp = user_cart::where("user_id", "=", $id)->get();
            $ordersListTemp = order::where("user_id", "=", $id)->get();
            $reviewsListTemp = review::where("user_id", "=", $id)->get();

            if (count($userCartListTemp) !== 0) {
                $flag = false;
            }
            if (count($ordersListTemp) !== 0) {
                $flag = false;
            }
            if (count($reviewsListTemp) !== 0) {
                $flag = false;
            }
            if ($flag) {
                $user->delete();
                return response()->json([
                    'message' => 'deleted user'
                ]);
            }
        }
        if (!$user) {
            return response()->json([
                'message' => 'user not found !!!'
            ]);
        }
        return response()->json([
            'message' => "can't delete user because have related ingredients."
        ]);
    }


    private function getName($n)
    {
        $characters = '162379812362378dhajsduqwyeuiasuiqwy460123';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public  function Xulyid($id): String
    {
        $dodaichuoi = strlen($id);
        $chuoitruoc = $this->getName(10);
        $chuoisau = $this->getName(22);
        $handle_id = base64_encode($chuoitruoc . $id . $chuoisau);
        return $handle_id;
    }

    public function DichId($id)
    {
        $id = base64_decode($id);
        $handleFirst = substr($id, 10);
        $idx = "";
        for ($i = 0; $i < strlen($handleFirst) - 22; $i++) {
            $idx .= $handleFirst[$i];
        }
        return  $idx;
    }

    public function getSearch(Request $request)
    {
        $user = users::where('Username', 'like', '%' . $request->key . '%')
            ->orwhere('email', 'like', '%' . $request->key . '%')
            ->orwhere('address', 'like', '%' . $request->key . '%')
            ->get();
        //return view('admin.user.search', compact('user'));
        if ($user) {
            if (empty(count($user))) {
                return response()->json([
                    'message' => 'user not found!',
                ]);
            } else {
                return response()->json([
                    'message' => count($user) . ' user found!!!',
                    'item' => $user
                ]);
            }
        }
    }
}
