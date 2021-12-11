<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\order_details;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\review;
use App\Models\user_cart;
use Illuminate\Support\Facades\Validator;

//Duyen Controller
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return products::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|min:2|max:40|unique:products,product_name',
            'price' => 'required',
            'product_image' => 'required',
            'description' => 'required|min:10|max:200',
            'quantity' => 'required',
            'category_id'=>'required'
        ]);
        if ($validator->fails()){
            return  response()->json(['status'=>'Have a problem with your data ']);
        }
        $pattern_Integer = '/^\d{1,}$/';
        // xét pattern  quantity + categoryid
        if (!preg_match($pattern_Integer,$request->quantity)|| !preg_match($pattern_Integer,$request->category_id)){
            if (!preg_match($pattern_Integer,$request->quantity)){
                return  response()->json(['status'=>'quantity must is positive integers']);
            }
            else{
                return  response()->json(['status'=>'Category id must is positive integers']);
            }
        }
        // Khúc này chú ý nhập giá nhập số  thế này :
        // EX : 123.22 bắt buộc có 2 số sau dấu chấm còn số ở trước thì bao nhiêu số cũng dc
        // EX : 123.22(dấu chấm not dấu phẩy ) , 88.32,99.12,642.88,54622.99
        $pattern_price = '/^\d{1,}\.{1,1}\d{2,2}$/';
        if (!preg_match($pattern_price,$request->price)){
            return  response()->json(['status'=>'Price must have 2 number after dot and must is not negative ']);
        }
        if (!$request->hasFile('product_image')){
            return "Please Choose File";
        }
        $image = $request->file('product_image');
        $array_image_type = ['png','jpg','jpeg','svg'];
        if (!in_array($image->getClientOriginalExtension(),$array_image_type)){
            return  response()->json(['status'=>'Please Choose type image is png  or jpg  or jpeg or svg']);
        }
        $checksize = 2097152;
        if ($image->getSize()>$checksize){
            return  response()->json(['status'=>'Please file is shorter than 2mb']);
        }
        try {
            categories::findOrFail($request->category_id);
        }catch (\Exception $exception){
            return  response()->json(['status'=>'Invalid category - category must is a number in select']);
        }
        // dd(storage_path('public/' .'1638934974tong-hop-cac-mau-background-dep-nhat-10070-6.jpg'));
        // Đoạn code trên ko dc xóa , nó là đường link ảnh lưu lên db đó
        $filename = time().$image->getClientOriginalName();
        $duongdan = storage_path('public/' .$filename); // cái này để lưu lên database
        $request->file('product_image')->storeAs('public',$filename);
        $product = new products([
            'product_name' => $request->get('product_name'),
            'price' => $request->get('price'),
            'description' => $request->get('description'),
            'quantity' => $request->get('quantity'),
            'product_image' => $duongdan,
            'category_id' => $request->get('category_id'),
        ]);
        $product->save();
        return  response()->json(['status'=>'Create Product Success']);

       // return products::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(products $product)
    {
        return $product;
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
        $product = products::find($id);
        if ($product) {
            $product->update($request->all());
            return response()->json([
                'message' => 'product updated!',
                'product' => $product
            ]);
        }
        return response()->json([
            'message' => 'product not found !!!'
        ]);

        // $product->update($request->all());
        // return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        $pattern_id = '/^\d{1,}$/';
//        // Check số id
//        if (!preg_match($pattern_id,$id)){
//            return  response()->json(['status'=>'Please type id is a number ']);
//        }
//        // check id not found
//        $category = categories::find($id);
//        if ($category == null){
//            return response()->json(['status'=>'Not found your category id']);
//        }
                $pattern_id = '/^\d{1,}$/';
        if (!preg_match($pattern_id,$id)){
            return  response()->json(['message'=>'Please type id is a number']);
        }
        $flag = true;
        $product = products::find($id);
        if ($product == null) {
            return response()->json([
                'message' => 'product not found !!!'
            ]);
        }

        $userCartListTemp = user_cart::where("product_id", "=", $id)->get();
        $ordersDetailListTemp = order_details::where("product_id", "=", $id)->get();

        if (count($userCartListTemp) !== 0) {
            $flag = false;
        }
        if (count($ordersDetailListTemp) !== 0) {
            $flag = false;
        }

        if ($flag) {
            $reviewsListRemove = review::where("product_id", "=", $id)->delete();
            $product->delete();
            return response()->json([
                'message' => 'product and reviews depended deleted'
            ]);
        }
        return response()->json([
            'message' => "can't delete product because have related ingredients."
        ]);
    }
}
