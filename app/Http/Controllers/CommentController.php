<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\products;
use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // Watch comment Auth bao gồm cả quyền delete comment ở admin
    // đồng thời bao gồm phân quyền user r nhé
    // đã fix : Không có field id lên
    // Id không phải là số nguyên
    // Không tìm thấy id

    public function  WatchComment(Request $request)
    {
        if (!$request->has('product_id')) {
            return  response()->json(['status' => 'Please add product id to find comment'], 404);
        }
        $product_id = $request->query('product_id');
        if (!gettype($product_id) == 'integer') {
            return  response()->json(['status' => "Product id not is number "]);
        }
        try {
            $product = products::findOrFail($product_id);
        } catch (\Exception $e) {
            return  response()->json(['status' => 'error not found product id ']);
        }

        $allComment = comment::where('product_id', '=', $product->id)->get();
        // Khúc này  là check quyền của user
        if (Auth::guard('api')->check()) {
            // If có đăng nhập thì khúc dưới chưa bao gồm trường hợp  admin delete comment
            // Check comment của đúng user đó hiển thị ra danh sách quyền trên comment đó .

            foreach ($allComment as $comment) {
                if (Gate::allows('edit-comment', $comment)) {
                    $comment['quyen'] = 'edit,delete';
                } else {
                    $comment['quyen'] = "";
                }
            }
            // Khúc này là quyền delete  của admin nha
            if (Auth::user()->type == 1) {
                foreach ($allComment as $comment) {
                    if (Gate::allows('delete-comment', $comment)) {
                        if (empty($comment['quyen'])) {
                            $comment['quyen'] = 'delete';
                        }
                    }
                }
            }
        }
        return $allComment;
    }
    public  function WatchCommentNotAuth(Request  $request)
    {
        if (!$request->has('product_id')) {
            return  response()->json(['status' => 'Please add product id to find comment'], 404);
        }
        $product_id = $request->query('product_id');
        if (!gettype($product_id) == 'integer') {
            return  response()->json(['status' => "Product id not is number "]);
        }
        try {
            $product = products::findOrFail($product_id);
        } catch (\Exception $e) {
            return  response()->json(['status' => 'error not found product id ']);
        }
        $allComment = comment::where('product_id', '=', $product->id)->get();
        foreach ($allComment as $comment) {
            $comment['quyen'] = "";
        }
        return $allComment;
    }




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
