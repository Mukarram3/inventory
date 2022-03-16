<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $fillable=['id','category_name'];
    public function hasproduct(){
        return $this->hasOne(product::class,'id');
    }
}
