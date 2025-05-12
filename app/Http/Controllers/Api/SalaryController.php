<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Salary;

class SalaryController extends Controller
{
    public function salaryPaid(Request $request, string $id)
    {
        $validData = $request->validate([
            'att_month' => 'required',
        ]);

        $check = Salary::where('employee_id', $id)->where('salary_month', $request->att_month)->first();
        if ($check) {
            return response()->json([
                'message' => 'Salary already paid'
            ]);
        } else {
            // Insert the salary record
            Salary::where('id', $id)->insert([
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
        $salaries = Salary::select('salary_month')->groupBy('salary_month')->get();
        return response()->json($salaries);
    }
    public function viewSalary($id)
    {
        // Fetch all salaries for the given month
        $salaries = Salary::with('employee')
            ->where('salary_month', $id)
            ->get();
        return response()->json($salaries);
    }
    public function editSalary(string $id)
    {
        $salary = Salary::with('employee')->find($id);
        return response()->json($salary);
    }
    public function updateSalary(Request $request, string $id)
    {
        $salary = Salary::where('id', $id)->update([
            'employee_id' => $request->id,
            'amount' => $request->salary,
            'salary_month' => $request->att_month,
        ]);
        return response()->json([
            'message' => 'Salary updated successfully'
        ]);
    }
}
