<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;
use App\Models\products;
use App\Http\Controllers\EncryptId;

use function PHPUnit\Framework\isEmpty;

use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = categories::all()->toArray();
        $return = [];
        foreach($categories as $item){
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
//        $validator = Validator::make($request->all(),[
//            'name'=>'required|unique:categories,name',
//        ]);
//
//            if ($validator->fails()){
//                return response(['errors'=>$validator->errors()->all()], 422);
//            }
//        $category = new categories([
//            'name' => $request->get('name'),
//            'description' => $request->get('description'),
//            //'image' => basename($request->file('category_image')->store('public/images'))
//            'image' => '',
//        ]);
//        $category->save();
//        return response()->json([
//            'message' => 'insert categories successfully!',
      //  ]);
        if (!$request->hasFile('category_image')){
            return response()->json(['error'=>'Please Choose File']);
        }
        $image = $request->file('category_image');
        $array_image_type = ['png','jpg','jpeg','svg'];
        if (!in_array($image->getClientOriginalExtension(),$array_image_type)){
            return  response()->json(['errors'=>'Please Choose type image is png  or jpg  or jpeg or svg']);
        }
        $checksize = 2097152;
        if ($image->getSize()>$checksize){
            return  response()->json(['errors'=>'Please file is shorter than 2mb']);
        }
                $validator = Validator::make($request->all(),[
            'name'=>'required|unique:categories,name',
            'description'=> 'required|max:200',
        ]);
        if ($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $filename = time().$this->getANumberRamdom().$image->getClientOriginalName();
        $duongdan = storage_path('public/' .$filename); // cái này để lưu lên database
        $request->file('category_image')->storeAs('public',$filename);
        $category = new categories;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $duongdan;
        $category->save();
        return response(['status'=>"Create successful"], 200);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request  $request)
    {
        $id = $request->id;
        $cat_id = EncryptId::DichId($id);
        $category = categories::find($cat_id);
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
        $id = EncryptId::DichId($id);
        $pattern_id = '/^\d{1,}$/';
        if (!preg_match($pattern_id,$id)){
            return  response()->json(['message'=>'Please type id is a number']);
        }
        try {
            $category =   categories::findOrFail($id);
        }catch (\Exception $exception){
            return  response()->json(['message'=>'Please type right category id']);
        }
        $old_name = $request->old_name;
        $old_desc = $request->old_desc;
        $old_image = $request->old_category_image;
         // Check loi version
        if ($category->name != $old_name || $category->description != $old_desc || $category->image != $old_image){
            return  response()->json(['message'=>'Can not update have a problem with your data ']);
        }
        if ($category->name != $request->name){
            $check = categories::where('name','=',$request->name)->get();
            if ($check!=null){
                return  response()->json(['message'=>'That name are already']);
            }
            $category->name = $request->name;
        }
        if ($category->description != $request->desc){
            $category->description = $request->desc;
        }
        $public_image_name = $this->getImageName(array_reverse(explode('\\',$category->image))[0]);

        if ($public_image_name != $request->file('category_image')->getClientOriginalName()){
            if (!$request->hasFile('category_image')){
                return response()->json(['message'=>'Please Choose File']);
            }
            $image = $request->file('category_image');
            $array_image_type = ['png','jpg','jpeg','svg'];
            if (!in_array($image->getClientOriginalExtension(),$array_image_type)){
                return  response()->json(['message'=>'Please Choose type image is png  or jpg  or jpeg or svg']);
            }
            $checksize = 2097152;
            if ($image->getSize()>$checksize){
                return  response()->json(['message'=>'Please file is shorter than 2mb']);
            }
            $filename = time().$this->getANumberRamdom().$image->getClientOriginalName();
            $duongdan = storage_path('public/' .$filename);
            $request->file('category_image')->storeAs('public',$filename);
            $category->image = $duongdan;
            $category->save();
            return  response()->json(['message'=>'Update Successful']);

        }




    }



    private function getImageName($public_image_name){
        return explode('/',$public_image_name)[1];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $id = $request->id;
        $id = EncryptId::DichId($id);
        $pattern_id = '/^\d{1,}$/';
        if (!preg_match($pattern_id,$id)){
            return  response()->json(['message'=>'Please type id is a number']);
        }
        $category = categories::find($id);
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

    private function getANumberRamdom(){
        $characters = '162379812362378dhajsduqwyeuiasuiqwy460123';
        $randomString = '';
        $n = random_int(1,strlen($characters)-1);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }



    public function getSearch(Request $request){
        $category = categories::where('name','like','%'.$request->key.'%')->get();
        if($category){
            if(empty(count($category))){
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
}
