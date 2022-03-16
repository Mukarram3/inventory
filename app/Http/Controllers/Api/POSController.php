<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function GetProduct($id){
        $products=products::where('category_id',$id)->get();
        return response()->json($products);
    }
}
