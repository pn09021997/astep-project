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
        return $categories;
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
        $category = new categories([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            //'image' => basename($request->file('category_image')->store('public/images'))
            'image' => '',
        ]);
        $category->save();
        return response()->json([
            'message' => 'insert categories successfully!',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $category = categories::find($id);
        if ($category) {
            return response()->json([
                'message' => 'category found!',
                'category' => $category,
            ]);
        }
        return response()->json([
            'message' => 'category not found!',
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
        $item = categories::find($id);
        return response()->json([
            'message' => 'Categories find it !!!',
            'item' => $item
        ]);
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
        /*$request->validate([
            'category_name' => 'required',
            'category_image' => ''
        ]);*/

        //2 Tao Product Model, gan gia tri tu form len cac thuoc tinh cua category model
        $category = categories::find($id);
        $category->name = $request->get('name');
        $category->description = $request->get('description');
        $category->image = "";


        //3 Luu
        $category->save();
        return response()->json([
            'message' => 'categories updated successfully !!!',
            'category' => $category,
        ]);
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

        if ($category) {
            $category->delete();
            return response()->json([
                'message' => 'category deleted successfully !!!',
            ]);
        } 
        return response()->json([
            'message' => 'category not found !!!'
        ]);
    }
    public function getSearch(Request $request){
        $category = categories::where('name','like','%'.$request->key.'%')->get();
        if($category){
            if(empty(count($category))){
                return response()->json([
                    'message' => 'category not found!',
                ]);
            }
            else{
                return response()->json([
                    'message' => count($category). ' category found!!!',
                    'item' => $category
                ]);
            }
           
        }
        
    }
}
