<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\order_details;
use App\Models\user_cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BuyController extends Controller
{
    public function Buy(Request $request){
        $datacheck  = [
            'address' => $request->address,
            'instruction' => $request->instruction
        ];
        $validator = Validator::make($datacheck,[
            'address' => 'required',
            'instruction' => 'required'
        ]);
        if ($validator->fails()){
            return  response()->json(['status'=>'Please Type all field required']);
        }
        if(empty($request->address)){
            return  response()->json(['error'=>'Please Type Address']);
        }
        $address_value = $request->address;
        $address_check = false;
        for ($i = 0; $i < $address_value; $i++) {
           if ($address_value[$i]!=''){
               $address_check = true;
               break;
           }
        }
        if (!$address_check){
            return  response()->json(['status'=>'please type address']);
        }

        $cart_user_check = user_cart::where('user_id','=',Auth::id())->get();
        if(empty($cart_user_check->toArray())){
            return response()->json(['error'=>'Can Not Buy Because you not have any product in your cart']);
        };
        $user_id = Auth::id();
        $cart_user = user_cart::where('user_id','=',$user_id)->join('products','user_cart.product_id','=','products.id')->select('user_cart.product_id','products.price','user_cart.quantity')->get()->toArray();
        $address_value_macdinh = " ";
        // Nếu cả chưa mua và  address = gtri mặc định thì  thôi cho nó  là giá trị mặc định
        if(order::where('user_id','=',$user_id)->first() == null && Auth::user()->address==$address_value_macdinh){
            $user = Auth::user();
            $user->address = $request->address;
            $user->save();
        }
        $order = new order;
        $order->address = $request->address;
        $order->user_id = $user_id;
        $order->instruction = $request->instruction;
        $order->confirm = 0 ;
        $order->save();
        $order_id = $order->id;
        foreach ($cart_user as $value){
            $order_detail = new order_details;
            $order_detail->order_id = $order_id;
            $order_detail->product_id = $value['product_id'];
            $order_detail->order_quantity = $value['quantity'];
            $order_detail->product_price = $value['price'];
            $order_detail->confirm = 0;
            $order_detail->save();
        }
        user_cart::where('user_id','=',$user_id)->delete(); // todo xóa các dữ liệu trong  user cart đi cho trống
        // Todo nếu thành công 2 cái này nó sẽ tạo order id và tạo order details phù hợp cho nó
        return response()->json(['status'=>'Success']);
    }

    public  function   DisplayProductBuy(){

    }
}
