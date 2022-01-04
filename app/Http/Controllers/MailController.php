<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class MailController extends Controller
{

    public static function  SendMailRegister($email,$verify_code){
        $detail = [
            'verify_code'=>$verify_code,
        ];
        $detail['verify_code'] = URL::to('/'). '/verify/verify?code='.$verify_code;
        Mail::to($email)->send(new RegisterMail($detail));

    }
}
