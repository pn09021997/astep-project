<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsefulController extends Controller
{
    // Các hàm hay sử dụng quăng hết vào đây
    public static function  checkTypeIsInteger($data){
        $pattern_Integer = '/^\d{1,}$/';
        if (!preg_match($pattern_Integer,$data)){
            return false;
        }
        return true;
    }


}
