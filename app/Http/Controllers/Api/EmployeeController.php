<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\employee;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $employee= employee::all();
        return response()->json($employee);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:employees|max:255',
            'email' => 'required|unique:employees',
            'phone' => 'required|unique:employees',
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



            $employee= new employee();
            $employee->name= $request->name;
            $employee->email= $request->email;
            $employee->address= $request->address;
            $employee->salary= $request->salary;
            $employee->joining_date= $request->joining_date;
            $employee->nid= $request->nid;
            $employee->phone= $request->phone;
            $employee->photo= $image_url;



            $employee->save();
        }
        else{
            $employee= new employee();
            $employee->name= $request->name;
            $employee->email= $request->email;
            $employee->address= $request->address;
            $employee->salary= $request->salary;
            $employee->joining_date= $request->joining_date;
            $employee->nid= $request->nid;
            $employee->phone= $request->phone;
            $employee->save();
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
        $employee=employee::find($id);
        return  response()->json($employee);
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
        $data['salary'] = $request->salary;
        $data['address'] = $request->address;
        $data['nid'] = $request->nid;
        $data['joining_date'] = $request->joining_date;
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
                $img = DB::table('employees')->where('id',$id)->first();
                $image_path = $img->photo;
                $done = unlink($image_path);
                $user  = DB::table('employees')->where('id',$id)->update($data);
            }

        }else{
            $oldphoto = $request->photo;
            $data['photo'] = $oldphoto;
            $user = DB::table('employees')->where('id',$id)->update($data);
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
        $employee= employee::find($id);
        if ($employee->photo){
            unlink($employee->photo);
        }
            $employee->delete();
    }
}
