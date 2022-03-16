<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;
    protected $table='salaries';
    protected $fillable=['id','employee_id','amount','salary_date','salary_month','salary_year'];
}
