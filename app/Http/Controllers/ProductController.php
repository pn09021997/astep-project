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
        foreach ($products as $item) {
            $item['id'] = $this->Xulyid($item['id']);
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
            'description' => 'required|min:10|max:200',
            'quantity' => 'required',
            'category_id' => 'required'
        ]);
        if ($validator->fails()) {
            return  response()->json(['status' => 'Have a problem with your data ']);
        }
        $pattern_Integer = '/^\d{1,}$/';
        // xét pattern  quantity + categoryid
        if (!preg_match($pattern_Integer, $request->quantity) || !preg_match($pattern_Integer, $request->category_id)) {
            if (!preg_match($pattern_Integer, $request->quantity)) {
                return  response()->json(['status' => 'quantity must is positive integers']);
            } else {
                return  response()->json(['status' => 'Category id must is positive integers']);
            }
        }
        // Khúc này chú ý nhập giá nhập số  thế này :
        // EX : 123.22 bắt buộc có 2 số sau dấu chấm còn số ở trước thì bao nhiêu số cũng dc
        // EX : 123.22(dấu chấm not dấu phẩy ) , 88.32,99.12,642.88,54622.99
        $pattern_price = '/^\d{1,}\.{1,1}\d{2,2}$/';
        if (!preg_match($pattern_price, $request->price)) {
            return  response()->json(['status' => 'Price must have 2 number after dot and must is not negative ']);
        }
        if (!$request->hasFile('product_image')) {
            return "Please Choose File";
        }
        $image = $request->file('product_image');
        $array_image_type = ['png', 'jpg', 'jpeg', 'svg'];
        if (!in_array($image->getClientOriginalExtension(), $array_image_type)) {
            return  response()->json(['status' => 'Please Choose type image is png  or jpg  or jpeg or svg']);
        }
        $checksize = 2097152;
        if ($image->getSize() > $checksize) {
            return  response()->json(['status' => 'Please file is shorter than 2mb']);
        }
        try {
            categories::findOrFail($request->category_id);
        } catch (\Exception $exception) {
            return  response()->json(['status' => 'Invalid category - category must is a number in select']);
        }
        // dd(storage_path('public/' .'1638934974tong-hop-cac-mau-background-dep-nhat-10070-6.jpg'));
        // Đoạn code trên ko dc xóa , nó là đường link ảnh lưu lên db đó
        $filename = time() . $image->getClientOriginalName();
        $duongdan = storage_path('public/' . $filename); // cái này để lưu lên database
        $request->file('product_image')->storeAs('public', $filename);
        $product = new products([
            'product_name' => $request->get('product_name'),
            'price' => $request->get('price'),
            'description' => $request->get('description'),
            'quantity' => $request->get('quantity'),
            'product_image' => $duongdan,
            'category_id' => $request->get('category_id'),
        ]);
        $product->save();
        return  response()->json(['status' => 'Create Product Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) //get item by id
    {
        $pro_id = $this->DichId($id);
        $product = products::where('id', '=', $id)->get();
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
        $list = products::all()->toArray();
        $return = [];
        foreach ($list as $item) {
            $item['id'] = $this->Xulyid($item['id']);
            $return[] = $item;
        }

        $pro_id = $this->DichId($id);
        $product = products::find($pro_id);


        if ($product) {


            $validator = Validator::make($request->all(), [
                'product_name' => 'required',

            ]);

            if ($validator->fails()) {
                return response(['errors' => $validator->errors()->all()], 422);
            }
            //Kiem tra product_name da co hay chua, co bi trung khong
            if ($request->product_name == $list[0]['product_name']) {
                return response()->json([
                    'message' => 'The product_name has been exits!!!',
                ]);
            } else {
                $pro_name = $request->product_name;
            }


            $product->update([
                $product->product_name = $pro_name,
                $product->price = $request->get('price'),
                $product->description = $request->get('description'),
                $product->quantity = $request->get('quantity'),
                // $product->pro_image = $request->get('pro_image');
            ]);


            $product->save();
            return response()->json([
                'message' => 'product updated!',
                'product' => $product
            ]);
        }

        return response()->json([
            'message' => 'product not found !!!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) //remove
    {
        $id = $this->DichId($id);
        $pattern_id = '/^\d{1,}$/';
        if (!preg_match($pattern_id, $id)) {
            return  response()->json(['message' => 'Please type id is a number']);
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

    private function getName($n)
    {
        $characters = '162379812362378dhajsduqwyeuiasuiqwy460123';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    public  function Xulyid($id): String
    {
        $dodaichuoi = strlen($id);
        $chuoitruoc = $this->getName(10);
        $chuoisau = $this->getName(22);
        $handle_id = base64_encode($chuoitruoc . $id . $chuoisau);
        return $handle_id;
    }

    public function DichId($id)
    {
        $id = base64_decode($id);
        $handleFirst = substr($id, 10);
        $idx = "";
        for ($i = 0; $i < strlen($handleFirst) - 22; $i++) {
            $idx .= $handleFirst[$i];
        }
        return  $idx;
    }

    public function filterProduct(Request $request)
    {
        $filterField = "product_name";
        $filterOption = "DESC";
        if ($request->key &&  $request->filter) {
            switch ($request->filter) {
                case "za": {
                        $filterOption = "ASC";
                        break;
                    }
                case "az": {
                        $filterOption = "DESC";
                        break;
                    }
                case "price-high-low": {
                        $filterField = "price";
                        $filterOption = "DESC";
                        break;
                    }
                case "price-low-high": {
                        $filterField = "price";
                        $filterOption = "ASC";
                        break;
                    }
                default: {
                        $filterField = "product_name";
                        $filterOption = "DESC";
                        break;
                    }
            }
            $productList = products::where('category_id', 'like', '%' . $request->key . '%')
                ->orderBy($filterField, $filterOption)
                ->get();
            return response()->json([
                'products' => $productList,
            ]);
        }
    }

    public function getSearch(Request $request)
    {
        if ($request->key) {
            $product = products::where('product_name', 'like', '%' . $request->key . '%')
                ->orwhere('price', 'like', '%' . $request->key . '%')
                ->get();
            //   return view('admin.product.search', compact('product'));
        } else {
            return response()->json([
                'message' => 'No product found',
            ]);
        }

        if ($product) {
            if (empty(count($product))) {
                return response()->json([
                    'message' => 'product not found!',
                    'item' => $product
                ]);
            } else {
                return response()->json([
                    'message' => count($product) . ' product found!!!',
                    'item' => $product
                ]);
            }
        }
    }
    public function GetProductById($productId)
    {
        $id = $productId;
        $pattern_product_id = '/^\d{1,}$/';
        if (!preg_match($pattern_product_id, $id)) {
            return  response()->json(['status' => "Please Type Id is Correct is a Number"]);
        }
        try { // Tìm kiếm product id nếu không ra thì vô cái cục catch thôi
            $product = products::findOrFail($id);
            $catename = categories::find($product->category_id);
            $category_SameType = $product->category_id;
            $sosp1trang = 4;
            $productSameType = DB::select("    SELECT * FROM `products` WHERE products.category_id = $category_SameType  ORDER BY RAND() LIMIT $sosp1trang;");
        } catch (\Exception $exception) {
            return  response()->json(['status' => "Not Found Product "]);
        }
        return  response()->json(['product' => $product, 'category' => $catename, 'relatedProducts' => $productSameType]);
    }
}
