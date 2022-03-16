<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

class OrderController extends Controller
{
    public function allOrders(){
        $date=date('d/m/Y');
        $order=DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->where('orders.order_date',$date)
            ->select('customers.name','orders.*')
            ->orderBy('orders.id','DESC')->get();
        return response()->json($order);
    }

    public function orders($id){
        $order=DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->where('orders.id',$id)
            ->select('customers.*','orders.*')
            ->first();
        return response()->json($order);
    }

    public function ordersdetails($id){
        $order=DB::table('order_details')
            ->join('products','order_details.product_id','products.id')
            ->where('order_details.order_id',$id)
            ->select('products.*','order_details.*')
            ->get();
        return response()->json($order);
    }

    public function searchorders(Request $request){
        $data=$request->date;
        $date=new DateTime($data);
        $searchdate=$date->format('d/m/Y');

//        return response()->json($searchdate);

        $searchorders=DB::table('orders')
            ->join('customers','orders.customer_id','customers.id')
            ->select('customers.name','orders.*')
            ->where('orders.order_date','07/10/2021')
            ->get();
        return response()->json($searchorders);
    }

    public function todaysell(){
        $date= date('d/m/Y');
        $todaysell=DB::table('orders')
            ->where('order_date',$date)->sum('total');
        return response()->json($todaysell);
    }
    public function todayincome(){
        $date= date('d/m/Y');
        $todayincome=DB::table('orders')
            ->where('order_date',$date)->sum('pay');
        return response()->json($todayincome);
    }
    public function todaydue(){
        $date= date('d/m/Y');
        $todaypaydue=DB::table('orders')
            ->where('order_date',$date)->sum('paydue');
        return response()->json($todaypaydue);
    }
    public function todayexpense(){
        $date= date('d/m/Y');
        $todayexpense=DB::table('expenses')
            ->where('expense_date',$date)->sum('amount');
        return response()->json($todayexpense);
    }

    public function stockout(){
        $stockout=DB::table('products')
            ->join('categories','products.category_id','categories.id')
            ->where('product_quantity','<','1')->get();
        return response()->json($stockout);
    }
}
