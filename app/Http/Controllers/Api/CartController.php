<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\pos;
use App\Models\product;
use App\Models\extra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function AddToCart($id){
        $product=product::find($id);

        $check=pos::where('pro_id',$id)->first();
        if ($check){
            $pos=pos::where('pro_id',$id)->first();
            $pos->increment('pro_quantity');
            $pos->sub_total=$pos->pro_quantity * $pos->pro_price;
            $pos->update();


        }
        else{
            $data=new pos();
            $data->pro_id=$id;
            $data->pro_name=$product->product_name;
            $data->pro_quantity=1;
            $data->pro_price=$product->selling_price;
            $data->sub_total=$product->selling_price;

            $data->save();

        }


    }

    public function CartProduct(){
        $data=pos::all();
        return response()->json($data);
    }

    public function deleteCart($id){
        pos::find($id)->delete();
    }

    public function increment($id){
        $product=pos::find($id);
        $product->increment('pro_quantity');
        $product->sub_total=$product->pro_quantity * $product->pro_price;
        $product->update();
    }
    public function decrement($id){
        $pos=pos::find($id);
        $pos->decrement('pro_quantity');
        $pos->sub_total=$pos->sub_total - $pos->pro_price;
        $pos->update();

//        $product=product::find('id',$pos->pro_id);
//        $product->increment('product_quantity');
//        $product->update();
    }

    public function discount(){
        $data=DB::table('extras')->first();
        return response()->json($data);
    }

    public function orderdone(Request $request){
        $data= array();
        $data['customer_id']=$request->customer_id;
        $data['qty']=$request->qty;
        $data['sub_total']=$request->subtotal;
        $data['discount']=$request->discount;
        $data['total']=$request->total;
        $data['payby']=$request->payby;
        $data['paydue']=$request->paydue;
        $data['pay']=$request->pay;
        $data['order_date']=date('d/m/Y');
        $data['order_month']=date('F');
        $data['order_year']=date('Y');

        $orderid=DB::table('orders')->insertGetId($data);

        $pos=pos::all();

        $ODdata=array();

        foreach ($pos as $podata){
            $ODdata['order_id']=$orderid;
            $ODdata['product_id']=$podata->pro_id;
            $ODdata['pro_quantity']=$podata->pro_quantity;
            $ODdata['pro_price']=$podata->pro_price;
            $ODdata['pro_subtotal']=$podata->sub_total;
            DB::table('order_details')->insert($ODdata);

            DB::table('products')->where('id',$podata->pro_id)
                ->update(['product_quantity' => DB::raw('product_quantity -'.$podata->pro_quantity)]);
        }

        DB::table('poses')->delete();

    }

}
