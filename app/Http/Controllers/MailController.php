<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function SendMail(){
        $detail =   [
          'title'=>'Just is a Mail for Dev',
            'body'=>'Hello From Tuấn Tôm '
        ];
        Mail::to('abc@gmail.com')->send(new TestMail($detail));
        return "Email sent";
    }

    public static function  SendMailRegister($email,$verify_code){
    $detail = [
        'verify_code'=>$verify_code,
    ];
    $detail['verify_code'] = env('APP_URL') . '/verify/verify?code='.$verify_code;
        Mail::to($email)->send(new RegisterMail($detail));
    }
}
