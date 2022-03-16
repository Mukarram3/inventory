<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    use HasFactory;
    protected $table='suppliers';
    protected $fillable=['id','name','email','address','phone','photo','shopname'];
    public function hasproduct(){
        return $this->hasOne(product::class,'id');
    }
}
