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
            'description' => 'required|min:10|max:200',
            'quantity' => 'required',
            'category_id' => 'required'
        ]);
        if ($validator->fails()) {
            return  response()->json(['status' => 'Have a problem with your data ']);
        }
        $pattern_price = '/^\d{1,}\.{1,1}\d{2,2}$/';
        if (!preg_match($pattern_price, $request->price)) {
            return  response()->json(['status' => 'Price must have 2 number after dot and must is not negative ']);
        }
        /*if (!$request->hasFile('product_image')) {
            return "Please Choose File";
        }
        $image = $request->file('product_image');
        $array_image_type = ['png', 'jpg', 'jpeg', 'svg'];
        if (!in_array($image->getClientOriginalExtension(), $array_image_type)) {
            return  response()->json(['status' => 'Please Choose type image is png  or jpg  or jpeg or svg']);
        }
        $filename = time() . $image->getClientOriginalName();
        $duongdan = storage_path('public/' . $filename);
        $request->file('product_image')->storeAs('public', $filename);
        */

        try {
            $idCategory = $this->DichId($request->category_id);
            categories::findOrFail($idCategory);
        } catch (\Exception $exception) {
            return  response()->json(['status' => 'Invalid category - category must is a number in select']);
        }

        $product = new products([
            'product_name' => $request->get('product_name'),
            'price' => $request->get('price'),
            'description' => $request->get('description'),
            'quantity' => $request->get('quantity'),
            'product_image' => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOAAAADgCAMAAAAt85rTAAAAYFBMVEXy8vJ2dnb19fX5+flxcXFzc3Pq6urMzMyurq5ubm5+fn6FhYVra2vi4uLn5+fu7u6+vr6VlZW3t7fFxcWQkJDT09Oampre3t6Tk5N6enqhoaHY2Nirq6uKioqenp67u7tegggxAAAE4klEQVR4nO3c63qrKBgFYP0QDxCPeIjH3P9dDmhMTJM9iXtmWtmz3j9NjenDKghioY4DAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA3yD1d3Hopwu8TxqM0WkHEcZ2Jbxw7u4S5clPl3kHakbuetEO+tdxYT9d7M+Rcl1RBJ9TJee1b08jpSziY0KfYyHnNrVRyjw+rr0GfVAxbPCsCyjj+RWLq/79EGBtQIo7KUQZvOs/rA3YS4+7nJ+GN3Voa8D0fB0N2+DvE1oakProOozz7umUh+9sDVh4a8Cn0j/emlkakIX3gPHDCWke5duElgak6t5E0+37Sa3v5M6bhJYGdFK5djJqU12UTOawd05uB20N6ARiThhtK5DS6TqBqG91aG1AJ9ADoeeF2/coX2dSvF7r0N6AxBoVOJsbGfLztedx79ehvQFNjW3HA/K77Ux4TWhzwC/Cx4m8t7RS2wNuesuvjyqW65BCqwOSytMl4xB9Deh6ZsS3vAYzl0+6nigNXz2JiurU8oCZHgx5l+h87Yt8Lpe+1QFJzYM9n5zX+WwPSOr6hJTLl/HWgPY9dLoGVLdh/VdPgk1AsrYGM/H2CbfVTfSDfDYHpOCX7fIPCRh67/Mh4BH9DwJG+wJaOkxQ0YoPlL55/mZjQD2f/4id88Hx9YT3NftqUF+DzWfVNyN9L3q2KaB5XCjkDq2eUNnzF2zH8Sfdf3Ju/nT2GZeLyqaA1NTc20VmNuUzj+dVuEfW/HSJd6N0D9tWcgEAAAAAAAAAAADAn4ws2tr5W9Tk/3QR/lNp6Fq2w3qvpE/fn7Q47i+CEbH4drGZxQf3sprDZE4wx2hZdbAcT1NzeP0Eo2TZhff48UNgsqhKIbu5LVJalDK/7fokJROqhniQ5cWhfpJlMa+0J1UKUcdNHevP99M4TkFdm+NJWMruzYbD78b4KLssFLLRBeylDLOu7a5dC2VezIK2rbOwnVQ7VBc56tPisxsGqmsns5v54uZF0QlPx6LKLYtL154P1TMxTwS6FTZjzZwkPyeMWCAuy3ukeELBadDHKlcq3SgbGTpOKCrTPhUvY1Ii042cNXJwHF90vn7di+JIdciWLZ40tIyU28xFK+6LmnUNnnrzchzn/QWhdGJ5WQLkOqAJZn6KEg27iJjNO+vFkYZP5g2mOKw4MVbw+RAFfAm61KBnvmHncjmNO010XVWR6SZ6KpYwaVuxuuxnBT9gQNIB6RYweg5Ylstp3OmvAUnpgN7SHKnRAXN3XcN2sIBzx2gC6hY5FzcTtyb6HDCNxXXdiOlkynpuuTSMMevy+xK242B8DmiaKCVl7etrqJLhMr4/N1ETMB2kudZY4OprMJBhzyi+6J6KGi9z9HFfHep/d2yuQd3PizwLClnfdoZ48XMNUlOOWVUVojar9pQUUz2OlXkzFF2minw82DBxuwb1l7hrXXFZ78/0OJiYC9J5CKjv4Lq2baWqpGnRaTAMeVvPn6ly4Y7hnsWK3+B6xWzvu27vLbdqz6cxqhLTSsn8wxL9hcVjff/4kRrob1tDVEt/q28OrFqR9zEql13a+obuDw2oeGHaZTyWH0+srGJ2FoquK9tj9Zz/JmrCrhvUgSe8/xQdcJILAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABgrb8AVdFTjJLjUDkAAAAASUVORK5CYII=",
            'category_id' => $this->DichId($request->get('category_id')),
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
        $product = products::where('id', '=', $pro_id)->get();
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
