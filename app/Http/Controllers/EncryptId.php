<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncryptId extends Controller
{
    private function getName($n) {
        $characters = '162379812362378dhajsduqwyeuiasuiqwy460123';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public  function Xulyid($id):String {
        $dodaichuoi = strlen($id);
        $chuoitruoc = $this->getName(10);
        $chuoisau = $this->getName(22);
        $handle_id = base64_encode($chuoitruoc.$id. $chuoisau);
        return $handle_id;
    }

    public function DichId($id){
        $id = base64_decode($id);
        $handleFirst = substr($id,10);
        $idx = "";
        for ($i=0; $i <strlen($handleFirst)-22 ; $i++) {
            $idx.=$handleFirst[$i];
        }
        return  $idx;
    }
}
