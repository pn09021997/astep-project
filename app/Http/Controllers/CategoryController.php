<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\products;
class CategoryController extends Controller
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
        return view('admin.category.index', compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
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
            'category_name' => 'required',
            'category_image' => ''
        ]);

        $category = new categories([
            'name' => $request->get('category_name'),
            'image' => basename($request->file('category_image')->store('public/images'))
        ]);
        $category->save();
        return redirect('/category')->with('success', 'Category added.');
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
        $item = categories::find($id);
        return view('admin.category.edit', compact('item'));
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
            'category_name' => 'required',
            'category_image' => ''
        ]);

        //2 Tao Product Model, gan gia tri tu form len cac thuoc tinh cua category model
        $category = categories::find($id);
        $category->name = $request->get('category_name');
        $category->image = $request->get('category_image');


        //3 Luu
        $category->save();
        return redirect('/category')->with('success', 'Category updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = categories::find($id);
        $category->delete();
        return redirect('/category')->with('success', 'Deleted.');
    }
    public function getSearch(Request $request){
        $category = categories::where('name','like','%'.$request->keyword.'%')->get();
                            return view('admin.category.search', compact('category'));
    }
}
