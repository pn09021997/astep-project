<?php

namespace App\Http\Controllers;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\OauthAccessToken;





class UserController extends Controller
{
    public  function loginview(){
        return view('auth.login');
    }

    public  function  login(Request  $request){
        $request->validate([
            'Username'=>'required|min:6|max:12', // khúc này ngon rồi
            'password'=>'required|min:6|max:12', // test rồi
        ]);
        $datax = [
            'Username'=>$request['Username'],
            'password'=>$request['password']
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

    public  function  registerview(){

        return view('auth.register');
    }

    public  function  register(Request  $request){
        
    /*$validator = Validator::make($request->all(),[
        'Username'=>'required|min:6|max:12|unique:users,Username', // khúc này ngon rồi
        'password'=>'required|min:6|max:12', // test rồi
        'email' => 'required|email|unique:users,email', // test luôn rồi
        'phone'=>'required|integer|digits:10|unique:users,phone', // khúc này test luôn rồi
    ]);*


        if ($validator->fails()){
            return  response()->json([
               "status" => 'Sign up Failed'
            ],500);
        }*/
        $data = [
          'Username'=>$request['Username'],
            'email'=>$request['email'],
            'phone'=>$request['phone'],
            'password'=>Hash::make( $request['password']),
            'type'=> 0
        ];
        DB::table('users')->insert($data);
        return response()->json([
            'status' => "Sign Up Success"
        ],200);
    }

    public  function  infoview(Request $request){
        $data = Auth::user();
        $datatoClient = [
          'email'=> $data['email'],
            'phone'=>$data['phone'],
            'address' => $data['address'],
        ];
        return response()-> json( $datatoClient);
    }

    public  function  infoPost(Request  $request){

        $data = Auth::user();
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email', // test luôn rồi
            'phone'=>'required|integer|digits:10|unique:users,phone', // khúc này test luôn rồi
        ]);
        if ($validator->fails()){
            return response()->json(['status'=>'Update Failed']);
        }
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data->save();
        return  response()->json(['status'=>'Update Success'],200);
    }

    public  function  PasswordUpdate(Request  $request){
        $data = Auth::user();
        $old_password = $request->old_password;
        if (!Hash::check($old_password,$data['password'])){
            return response()->json(['status'=>'old password is wrong ']);
        }
        $data['password'] = bcrypt($request['new_password']);
        $data->save();
        return response()->json(['status'=>'Update Success'],200);
    }

    public function  UserLogout(Request  $request){
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }
    }

/////Viet usercontroller

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = users::all();
     
        return response()->json($user);
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
        $request->validate([
            'Username' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'type' => 'required',
            'address' => 'required'
        ]);

        $user = new users([
            'Username' => $request->get('Username'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => $request->get('password'),
            'type' => $request->get('type'),
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
        $users = users::find($id);
        if ($users) {

            return response()->json([
                'message' => 'users found!',
                'users' => $users,
            ]);
        }
        return response()->json([
            'message' => 'users not found!',
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
        $users = users::find($id);
        return response()->json($users);
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
        $request->validate([
            'Username' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
            'type' => 'required',
            'address' => 'required'
        ]);

        //2 Tao Product Model, gan gia tri tu form len cac thuoc tinh cua Product model
        $user = users::find($id);
        $user->Username = $request->get('Username');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');
        $user->password = $request->get('password');
        $user->type = $request->get('type');
        $user->address = $request->get('address');
       

        //3 Luu
        $user->save();
        
        return response()->json([
            'message' => 'user updated!',
            'users' => $user
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
        $user = users::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'message' => 'user deleted'
            ]);
        } 
        return response()->json([
            'message' => 'user not found !!!'
        ]);
    }

    // public function getSearch(Request $request){
    //     $user = users::where('Username','like','%'.$request->key.'%')
    //                         ->orwhere('price','like','%'.$request->key.'%')
    //                         ->get();
    //                         return view('admin.product.search', compact('product'));
    // }


   
}
