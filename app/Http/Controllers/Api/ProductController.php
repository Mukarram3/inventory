<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\employee;
use Illuminate\Http\Request;
use App\Models\product;
use Illuminate\Support\Facades\DB;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=DB::table('products')
            ->join('categories','products.category_id','categories.id')
            ->join('suppliers','products.supplier_id','suppliers.id')
            ->select('suppliers.name','categories.category_name','products.*')
            ->orderBy('products.id','DESC')
            ->get();
//        $product=product::with('hascategory','hassupplier')->get();
        return response()->json($product);
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
            'product_name' => 'required|unique:products|max:255',
            'product_code' => 'required',
            'buying_price' => 'required'
        ]);

        if ($request->image){

            $position= strpos($request->image, ';');
            $sub=substr($request->image,0,$position);
            $ext= explode('/', $sub)[1];
            $fname= time().'.'.$ext;
            $img= Image::make($request->image)->resize(240,200);
            $upload_path= 'backened/employee/';
            $image_url= $upload_path.$fname;
            $img->save($image_url);



            $product= new product();
            $product->category_id= $request->category_id;
            $product->product_name= $request->product_name;
            $product->product_code= $request->product_code;
            $product->buying_price= $request->buying_price;
            $product->selling_price= $request->selling_price;
            $product->root= $request->root;
            $product->supplier_id= $request->supplier_id;
            $product->buying_date= $request->buying_date;
            $product->product_quantity= $request->product_quantity;
            $product->image= $image_url;



            $product->save();
        }
        else{
            $product= new product();
            $product->category_id= $request->category_id;
            $product->product_name= $request->product_name;
            $product->product_code= $request->product_code;
            $product->buying_price= $request->buying_price;
            $product->selling_price= $request->selling_price;
            $product->root= $request->root;
            $product->supplier_id= $request->supplier_id;
            $product->buying_date= $request->buying_date;
            $product->product_quantity= $request->product_quantity;
            $product->save();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=product::find($id);
        return response()->json($product);
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
        $data = array();
        $data['category_id'] = $request->category_id;
        $data['product_name'] = $request->product_name;
        $data['product_code'] = $request->product_code;
        $data['buying_price'] = $request->buying_price;
        $data['selling_price'] = $request->selling_price;
        $data['root'] = $request->root;
        $data['supplier_id'] = $request->supplier_id;
        $data['buying_date'] = $request->buying_date;
        $data['product_quantity'] = $request->product_quantity;
        $image = $request->newimage;

        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];

            $name = time().".".$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            $success = $img->save($image_url);

            if ($success) {
                $data['photo'] = $image_url;
                $img = DB::table('products')->where('id',$id)->first();
                $image_path = $img->image;
                $done = unlink($image_path);
                $user  = DB::table('products')->where('id',$id)->update($data);
            }

        }else{
            $oldphoto = $request->image;
            $data['image'] = $oldphoto;
            $user = DB::table('products')->where('id',$id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=product::find($id);
        if($product->image){
            unlink($product->image);
        }
        $product->delete();
    }

    public function updateStock($id,Request $request){
        $stock=product::find($id);
        $stock->product_quantity=$request->product_quantity;
        $stock->save();
    }
}
