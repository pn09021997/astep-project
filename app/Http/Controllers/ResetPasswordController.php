<?php

namespace App\Http\Controllers;

use App\Mail\PassWordReset;
use App\Models\PasswordResetModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;


class ResetPasswordController extends Controller
{
    private  function sendMail($verify_code,$email){
            $detail = [
                'verify_code'=>$verify_code,
            ];
            $detail['verify_code'] = URL::to('/'). '/password-reset/verify?code='.$verify_code;
            Mail::to($email)->send(new PassWordReset($detail));
    }

    public function recive_email(Request $request){
        $email = $request->email;
        $user = User::where('email',$email)->get()->toArray();
        if (empty($user)){
            return Redirect::back()->withErrors(['msg' => 'Not found your email please try another']);
        }
        $passwordReset = new PasswordResetModel;
        $passwordReset->token = sha1(time().$this->getANumberRamdom());
        $passwordReset->email = $email;
        $passwordReset->save();
       $this->sendMail($passwordReset->token,$email);
       echo "Please check your email to get new password";
    }

    private function getANumberRamdom(){
        $characters = '162379812362378dhajsduqwyeuiasuiqwy460123';
        $randomString = '';
        $n = random_int(1,strlen($characters)-1);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public  function  updatePassWord(Request $request){
        // nhận 3 giá trị token - new password - email

        $token = $request->token;
        $email = $request->email;
        $new_password = $request->new_password;
        $dulieu = PasswordResetModel::where('token','=',$token)->first();
        if (empty($dulieu)){
            return  "Your token is invalid !";
        }
        if ($dulieu->email != $email ){
            return  "Have a problem , can not update new password ! Please click and  type again all to set new password";
        }
       $pattern_password = '/.{6,12}/';
        if (!preg_match($pattern_password,$new_password)){
            return "Please write new password follow constraint";
        }
        // sau khi xét đủ update - xóa token
        $user = User::where('email','=',$email)->first();
        $user->password = bcrypt($new_password);
        $user->save();
        PasswordResetModel::where('email','=',$dulieu->email)->delete();
        return  "Your Password is Updated . Please login";
    }

    public function getformUpdate(Request  $request){
        $token = $request->query('code');
       $check =  PasswordResetModel::where('token','=',$token)->first();
        if (empty($check)){
            return  '<h1 style = "text-align: center"> Token is invalid </h1> ';
        }
        return view('email.ChangePasswordReset');
    }
}
