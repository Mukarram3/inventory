<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier= supplier::all();
        return response()->json($supplier);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate= $request->validate([
            'name' => 'required|unique:suppliers|max:255',
            'email' => 'required|unique:suppliers',
            'phone' => 'required|unique:suppliers'
        ]);

        if ($request->photo){

            $position= strpos($request->photo, ';');
            $sub=substr($request->photo,0,$position);
            $ext= explode('/', $sub)[1];
            $fname= time().'.'.$ext;
            $img= Image::make($request->photo)->resize(240,200);
            $upload_path= 'backened/employee/';
            $image_url= $upload_path.$fname;
            $img->save($image_url);



            $supplier= new supplier();
            $supplier->name= $request->name;
            $supplier->email= $request->email;
            $supplier->address= $request->address;
            $supplier->phone= $request->phone;
            $supplier->shopname= $request->shopname;
            $supplier->photo= $image_url;
            $supplier->save();
        }
        else{
            $supplier= new supplier();
            $supplier->name= $request->name;
            $supplier->email= $request->email;
            $supplier->address= $request->address;
            $supplier->shopname= $request->salary;
            $supplier->phone= $request->phone;
            $supplier->shopname= $request->shopname;
            $supplier->save();
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
        $supplier=supplier::find($id);
        return  response()->json($supplier);
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
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['shopname'] = $request->shopname;
        $image = $request->newphoto;

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
                $img = DB::table('suppliers')->where('id',$id)->first();
                $image_path = $img->photo;
                $done = unlink($image_path);
                $user  = DB::table('suppliers')->where('id',$id)->update($data);
            }

        }else{
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $user = DB::table('suppliers')->where('id',$id)->update($data);
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
        $supplier=supplier::find($id);
        $supplier->delete();
    }
}
