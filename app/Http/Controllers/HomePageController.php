<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function GetProductIsLastest(){
        $ProductIsLastest = products::orderBy('id','DESC')->limit(3)->get();
        return response()->json($ProductIsLastest,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
    public  function  GetCategoryIsRamdom(){
        $CategoryIsRamdom = DB::select("SELECT * FROM `categories` ORDER BY RAND() LIMIT 3;");
        return response()->json($CategoryIsRamdom,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

}
