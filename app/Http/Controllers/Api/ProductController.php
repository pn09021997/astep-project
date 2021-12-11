<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\order_details;
use Illuminate\Http\Request;
use App\Models\products;
use App\Models\review;
use App\Models\user_cart;

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
        $product = products::create($request->all());
        return response()->json([
            'message' => 'product created',
            'product' => $product
        ]);
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
        $flag = true;
        $product = products::find($id);
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
        return response()->json([
            'message' => "can't delete product because have related ingredients."
        ]);
    }
}
