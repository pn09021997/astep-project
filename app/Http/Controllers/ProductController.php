<?php

namespace App\Http\Controllers;

use App\Models\order_details;
use App\Models\review;
use App\Models\user_cart;
use Illuminate\Http\Request;
use App\Models\products;
use Illuminate\Support\Facades\DB;
use App\Models\categories;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\EncryptId;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = products::all()->toArray();
        $return = [];
        foreach($products as $item){
            $item['id'] = EncryptId::Xulyid($item['id']);
            $return[] = $item;
        }
        return response()->json($return);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'description' => 'required|max:200',
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) //get item by id
    {
        $pro_id = EncryptId::DichId($id);
        $product = products::find($pro_id);
        if ($product) {
            return response()->json([
                'message' => 'product found!',
                'product' => $product,
            ]);
        }
        return response()->json([
            'message' => 'product not found!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) //update
    {
        $id = EncryptId::DichId($id);
        try {
            $product =   products::findOrFail($id);
            dd($product);
        }catch (\Exception $exception){
            return  response()->json(['message'=>'Please type right product id']);
        }
        // Check Version
        $validator = Validator::make($request->all(),
        [
            'old_product_name' => 'required',
            'old_description' => 'required',
            'old_quantity' => 'required',
            'old_category_id' => 'required',
            'old_price' => 'required',
            'old_$old_product_image'=>'required',
        ]
        );
        if ($validator->fails()){
            return  response()->json(['message'=>'Have Problem with your data please refresh ']);
        }
        $old_product_name =$request->old_product_name;
        $old_description = $request->old_description;
        $old_quantity = $request->old_quantity;
        $old_category_id = $request->old_category_id;
        $old_price = $request->old_price;
        $old_product_image = $request->old_product_image;
        if ($old_product_name != $product->product_name
            || $old_description != $product->description ||
            $old_quantity != $product->quantity || $old_product_image != $product->product_image ||
             $old_price != $product->price || $old_category_id != $product->category_id){
            return  response()->json(['message'=>'Have Problem with your data please refresh ']);
        }
        $validator = Validator::make($request->all(),
            [
                'product_name' => 'required',
                'description' => 'required',
                'quantity' => 'required',
                'category_id' => 'required',
                'price' => 'required',
                'product_image'=>'required',
            ]
        );
        if ($validator->fails()){
            return  response()->json(['message'=>'Please type all field on screen']);
        }


        if ($product->product_name != $request->product_name){
            if ($this->check_product_name($request) == 1){
                return  response()->json(['message'=>'Product name is already']);
            }
            if ($this->check_product_name($request) == 2){
                return  response()->json(['message'=>'Your name length is not acceptable']);
            }
        $product->product_name = $request->product_name ;
        }
        if ($product->description != $request->description){
            if ($this->check_product_desc($request) == 1){
                return  response()->json(['message'=>'please write description shorter than 200 character']);
            }
            $product->description = $request->description ;
        }
        if ($product->quantity != $request->quantity){
            if ($this->check_type_is_interger($request->quantity) == 1){
                return  response()->json(['message'=>'please type quantity is a number']);
            }
            $product->quantity = $request->quantity;
        }
        if ($product->category_id != $request->category_id){
            if ($this->check_type_is_interger($request->category_id) == 1){
                return  response()->json(['message'=>'category not valid']);
            }
            try {
                categories::findOrFail($request->category_id);
            }catch (\Exception $exception){
                return  response()->json(['message'=>'Invalid category - category must is a number in select']);
            }
            $product->category_id = $request->category_id;
        }
        if ($product->price != $request->price){
        if ($this->check_price($request->price)==1){
            return  response()->json(['message'=>'Price must have 2 number after dot and must is not negative ']);;}
            $product->price = $request->price;
        }

        $public_image_name = $this->getImageName(array_reverse(explode('\\',$product->product_image))[0]);

        if ($public_image_name != $request->file('product_image')->getClientOriginalName()){
            if (!$request->hasFile('product_image')){
                return response()->json(['message'=>'Please Choose file']);
            }
            $image = $request->file('product_image');
            $array_image_type = ['png','jpg','jpeg','svg'];
            if (!in_array($image->getClientOriginalExtension(),$array_image_type)){
                return  response()->json(['message'=>'Please Choose type image is png  or jpg  or jpeg or svg']);
            }
            $checksize = 2097152;
            if ($image->getSize()>$checksize){
                return  response()->json(['message'=>'Please file is shorter than 2mb']);
            }
        }
    }

    private function getImageName($public_image_name){
        return explode('/',$public_image_name)[1];
    }

    private function  check_price($data){
        $pattern_price = '/^\d{1,}\.{1,1}\d{2,2}$/';
        if (!preg_match($pattern_price,$data)){
        return 1;
        }
        return 0 ;
    }


    private function check_type_is_interger($data){
        $pattern_Integer = '/^\d{1,}$/';
        if (!preg_match($pattern_Integer,$data)){
            return 1;
        }
        return  0 ;
    }

    private  function  check_product_desc($request){
        if (strlen($request->description)>200){
            return 1;
        }
        return  0;
    }

    private function  check_product_name($request){
        $checkDuplicateName = products::where('product_name','=',$request->product_name)->get();
        if ($checkDuplicateName!=null){return  1; }
        if (strlen($request->product_name)<2 || strlen($request->product_name)>40){
        return 2 ;
        }
        return  0 ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //remove
    {
        $id = EncryptId::DichId($id);
        $pattern_id = '/^\d{1,}$/';
        if (!preg_match($pattern_id,$id)){
            return  response()->json(['message'=>'Please type id is a number']);
        }
        $flag = true;
        $product = products::find($id);
        if ($product) {
            if (!$product) {
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
        }
        return response()->json([
            'message' => "can't delete product because have related ingredients."
        ]);
    }




    public function getSearch(Request $request){
        $product = products::where('product_name','like','%'.$request->key.'%')
                            ->orwhere('price','like','%'.$request->key.'%')
                            ->get();
                         //   return view('admin.product.search', compact('product'));
                           if($product){
                            if(empty(count($product))){
                                return response()->json([
                                    'message' => 'product not found!',
                                ]);
                            }
                            else{
                                return response()->json([
                                    'message' => count($product). ' product found!!!',
                                    'item' => $product
                                ]);
                            }
                        }
                    }
                    public function GetProductById(Request $request){
                        if (!$request->has('id')){return  response()->json(['error'=>'Please Type id product ']);};
                        $id = $request->query('id');
                        // Todo fix id không phải là số , số âm , số thực , là chuỗi , null , empty

                        $pattern_product_id = '/^\d{1,}$/';
                        if (!preg_match($pattern_product_id,$id)){
                            return  response()->json(['status'=>"Please Type Id is Correct is a Number"]);
                        }
                        try { // Tìm kiếm product id nếu không ra thì vô cái cục catch thôi
                         $product = products::findOrFail($id);
                        $catename = categories::find($product->category_id);
                         $category_SameType = $product->category_id;
                         $sosp1trang = 4 ;
                         $productSameType = DB::select("    SELECT * FROM `products` WHERE products.category_id = $category_SameType  ORDER BY RAND() LIMIT $sosp1trang;");
                        }catch (\Exception $exception){
                            return  response()->json(['status'=>"Not Found Product "]);
                        }
                        return  response()->json(['product'=>$product,'category'=>$catename,'SanphamcungLoai'=>$productSameType]);
                    }

}
