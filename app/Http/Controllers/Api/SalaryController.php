<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\salary;

class SalaryController extends Controller
{
    public function PaidSalary($id,Request $request){

        $check= salary::all()->where('employee_id',$id)->where('salary_month',$request->salary_month)->first();
        if ($check){
            return response()->json('Salary Already Paid');
        }
        else{
            $salary=array();
            $salary['employee_id']=$id;
            $salary['amount']=$request->salary;
            $salary['salary_date']=date('d/m/Y');
            $salary['salary_month']=$request->salary_month;
            $salary['salary_year']=date('Y');

            DB::table('salaries')->insert($salary);
        }


    }

    public function AllSalary(){
        $salary=DB::table('salaries')->select('salary_month')->groupBy('salary_month')->get();
        return response()->json($salary);
    }

    public function viewsalary($id){
        $salary=DB::table('salaries')
            ->join('employees','salaries.employee_id','employees.id')
            ->select('employees.name','salaries.*')
            ->where('salaries.salary_month',$id)
            ->get();
        return response()->json($salary);
    }

    public function editsalary($id){
        $salary=DB::table('salaries')
            ->join('employees','salaries.employee_id','employees.id')
            ->select('employees.name','employees.email','salaries.*')
            ->where('salaries.id',$id)
            ->first();
        return response()->json($salary);
    }

    public function updateSalary($id,Request $request){
        $salary=array();
        $salary['salary_month']=$request->salary_month;
        $salary['amount']=$request->amount;
        DB::table('salaries')->where('id',$id)->update($salary);
    }

}
