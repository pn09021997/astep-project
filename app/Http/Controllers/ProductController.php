<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = products::all();
        return response()->json($products);
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
        $validate = $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            //optional if you want this to be required
        ]);
        if ($validate) {
            $products = products::create($request->all());
            return response()->json([
                'message' => 'products created',
                'products' => $products
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $products = products::find($id);
        if ($products) {

            return response()->json([
                'message' => 'expense found!',
                'products' => $products,
            ]);
        }
        return response()->json([
            'message' => 'products not found!',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = products::find($id);
        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            //optional if you want this to be required
        ]);

        if ($validate) {
            $item = products::find($id);
            $item->name = $request->get('name');
            $item->amount = $request->get('amount');
            $item->description = $request->get('description');
            $item->category_id = $request->get('category_id');
            $item->price = $request->get('price');
            $item->product_image = $request->get('product_image');
            $item->save();

            return response()->json([
                'message' => 'products updated!',
                'products' => $item
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = products::find($id);
        if ($item) {
            $item->delete();
            return response()->json([
                'message' => 'products deleted'
            ]);
        } 
        return response()->json([
            'message' => 'products not found !!!'
        ]);
    }
}
