<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UsefulController;
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

    private  function  checkRate($rate_data){
        $rate = intval($rate_data);
        if ($rate<1 || $rate>5){
            return 1 ;
        }
        if (!UsefulController::checkTypeIsInteger($rate)){
            return  2 ;
        }
        return  0;


    }

    public function  postComment(Request $request){
        // Nhận product id - rate - content comment  -
        $product_id = $request->product_id;
        $rate = $request->rate;
        $content = $request->content_comment;

        if ($this->checkRate($rate)== 1){
           return response()->json(['status'=>'rate must from 1 to 5 start']);
        }
        if ($this->checkRate($rate)==2){
          return  response()->json(['status'=>'rate must is a number ']);
        }

        if (!UsefulController::checkTypeIsInteger($product_id)){
            return response()->json(['status'=>'Wrong product id']);
        }
        try {
            $product = products::findOrFail($product_id);
        }catch (\Exception $exception){
            return  response()->json(['status'=>'Not found your product']);
        }
        if ($this->check_comment_content($content)==1){
            return  response()->json(['status'=>'comment content is short than 200 character']);
        }
        $user_id = Auth::id();
        $comment = comment::where('product_id','=',$product_id)->where('user_id','=',$user_id)->first();
        if (!empty($comment)){
            // Không trống thì ??
                return  response()->json(['status'=>'You have comment this product']);
        }
        else{
            $comment_create = new comment ;
            $comment_create->product_id = $product_id;
            $comment_create->rate = $rate;
            $comment_create->user_id = $user_id;
            $comment_create->content = $content;
            $comment_create->save();
            return  response()->json(['status'=>'Comment is Create Successfully'],200);
        }

    }

    private  function  check_comment_content($comment_content){
    if (strlen($comment_content)>200){
        return 1;
    }
    return 0;
    }

    public  function updateComment($request){
        $product_id = $request->product_id;
        $rate = $request->rate;
        $content = $request->content_comment;
        if ($this->checkRate($rate)== 1){
            return response()->json(['status'=>'rate must from 1 to 5 start']);
        }
        if ($this->checkRate($rate)==2){
            return  response()->json(['status'=>'rate must is a number ']);
        }

        if (!UsefulController::checkTypeIsInteger($product_id)){
            return response()->json(['status'=>'Wrong product id']);
        }
        try {
            $product = products::findOrFail($product_id);
        }catch (\Exception $exception){
            return  response()->json(['status'=>'Not found your product']);
        }
        if ($this->check_comment_content($content)==1){
            return  response()->json(['status'=>'comment content is short than 200 character']);
        }
        $user_id = Auth::id();
        $comment = comment::where('product_id','=',$product_id)->where('user_id','=',$user_id)->first();
        if (Gate::allows('edit-comment', $comment)) {
            $comment->rate = $rate;
            $comment->content = $content;
            $comment->save();
        }
        else{
            return  response()->json(['status'=>'You  can not permission update comment on this comment '],403);
        }
    }

    public  function deleteComment(Request  $request){
        $product_id = $request->product_id;
        if (!UsefulController::checkTypeIsInteger($product_id)){
            return response()->json(['status'=>'Wrong product id']);
        }
        try {
            $product = products::findOrFail($product_id);
        }catch (\Exception $exception){
            return  response()->json(['status'=>'Not found your product'],404);
        }
        $user_id = Auth::id();
        $comment = comment::where('product_id','=',$product_id)->where('user_id','=',$user_id)->first();
        if (Gate::allows('delete-comment', $comment)) {
            comment::where('id','=',$comment->id)->first()->delete();
            return  response()->json(['status'=>'Delete successfully'],200);
        }
        else{
            return  response()->json(['status'=>' can not delete ! Permission '],403);
        }
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
