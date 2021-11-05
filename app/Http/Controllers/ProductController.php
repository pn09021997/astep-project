<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\categories;
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
        $categories = categories::all();
        return view('admin.product.index', compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = categories::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'product_image' => 'required',
            'description' => 'required',
            'quantity' => 'required'
        ]);

        $product = new products([
            'product_name' => $request->get('product_name'),
            'price' => $request->get('price'),
            'description' => $request->get('description'),
            'quantity' => $request->get('quantity'),
            'product_image' => basename($request->file('product_image')->store('public/images')),
            'category_id' => $request->category_id[0]
        ]);
        $product->save();
        return redirect('/product')->with('success', 'Product added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = products::find($id);
        return view('admin.product.edit', compact('item'));
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
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            // 'product_image' => 'required',
            'description' => 'required',
            'quantity' => 'required'
        ]);

        //2 Tao Product Model, gan gia tri tu form len cac thuoc tinh cua Product model
        $product = products::find($id);
        $product->product_name = $request->get('product_name');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->quantity = $request->get('quantity');
        // $product->pro_image = $request->get('pro_image');

        //3 Luu
        $product->save();
        return redirect('/product')->with('success', 'Product updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = products::find($id);
        $product->delete();
        return redirect('/product')->with('success', 'Deleted.');
    }

    public function getSearch(Request $request){
        $product = products::where('product_name','like','%'.$request->keyword.'%')
                            ->orwhere('price','like','%'.$request->keyword.'%')
                            ->get();
                            return view('admin.product.search', compact('product'));
    }
}
