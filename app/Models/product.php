<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $table='products';
    protected $fillable=['category_id','product_name','product_code','root','buying_price','selling_price','supplier_id','buying_date','image','product_quantity'];

    public function hascategory(){
        return $this->hasOne(category::class,'category_id');
    }
    public function hassupplier(){
        return $this->hasOne(supplier::class,'supplier_id');
    }

}
