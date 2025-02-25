<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    public function salaryPaid(Request $request, string $id)
    {
        $validData = $request->validate([
            'att_month' => 'required',
        ]);

        $check = DB::table('salaries')->where('employee_id', $id)->where('salary_month', $request->att_month)->first();
        if ($check) {
            return response()->json([
                'message' => 'Salary already paid'
            ]);
        } else {
            DB::table('salaries')->where('id', $id)->insert([
                'employee_id' => $id,
                'amount' => $request->salary,
                'salary_date' => date('Y-m-d'),
                'salary_month' => $request->att_month,
                'salary_year' => date('Y'),
            ]);
            return response()->json([
                'message' => 'Salary paid successfully'
            ]);
        }
    }
    public function salaries()
    {
        $salaries = DB::table('salaries')->select('salary_month')->groupBy('salary_month')->get();
        return response()->json($salaries);
    }

    public function viewSalary($id)
    {
        $salaries = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', 'employees.id')
            ->select('employees.name', 'salaries.*')
            ->where('salaries.salary_month', $id)->get();
        return response()->json($salaries);
    }

    public function editSalary(string $id)
    {
        $salary = DB::table('salaries')
            ->join('employees', 'salaries.employee_id', 'employees.id')
            ->where('salaries.id', $id)->first();
        return response()->json($salary);
    }
    public function updateSalary(Request $request, string $id)
    {
        $salary = DB::table('salaries')->where('id', $id)->update([
            'employee_id' => $request->id,
            'amount' => $request->salary,
            'salary_month' => $request->att_month,
        ]);
        return response()->json([
            'message' => 'Salary updated successfully'
        ]);
    }
}
