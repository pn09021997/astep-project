<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\products;

use function PHPUnit\Framework\isEmpty;

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
    public function show(categories $category)
    {
        return $category;
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
        //Complete check dependent products
        $pattern_id = '/^\d{1,}$/';
        // Check số id
        if (!preg_match($pattern_id,$id)){
            return  response()->json(['message'=>'Please type id is a number ']);
        }
        // check id not found
        $category = categories::find($id);
        if ($category == null){
            return response()->json(['message'=>'Not found your category id']);
        }

        $productListTemp =  products::where("category_id", "=", $id)->get();
        if (count($productListTemp) === 0) {
            $category->delete();
            return response()->json([
                'message' => 'categories deleted successfully !!!',
                'item' => $category
            ]);
        }
        return response()->json([
            'message' => "can't delete because have a dependent products",
        ]);
    }


    public function getSearch(Request $request)
    {
        $category = categories::where('name', 'like', '%' . $request->key . '%')->get();
        if ($category) {
            if (empty(count($category))) {
                return response()->json([
                    'message' => 'category not found!',
                ]);
            } else {
                return response()->json([
                    'message' => count($category) . ' category found!!!',
                    'item' => $category
                ]);
            }
        }
    }

    
    public function getProductByCategoryId(Request $request)
    {
        $category = categories::where('id', 'like', '%' . $request->key . '%')->get();
        if ($category) {
            if (empty(count($category))) {
                return response()->json([
                    'message' => 'category not found!',
                ]);
            } else {
                $productList = products::where('category_id', 'like', '%' . $request->key . '%')->get();
                return response()->json([
                    'message' => 'category found!!!',
                    'item' => $productList
                ]);
            }
        }
    }
}
