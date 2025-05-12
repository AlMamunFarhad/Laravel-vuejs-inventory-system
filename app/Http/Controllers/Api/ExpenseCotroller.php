<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Expense;

class ExpenseCotroller extends Controller
{
    public function index()
    {
        // Fetch all expenses from the database
        $expenses = Expense::get();
        return response()->json($expenses);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'amount' => 'required',
            'details' => 'required',
        ]);
        // Create a new expense
        Expense::create([
            'amount' => $request->amount,
            'details' => $request->details,
            'expense_date' => $request->expense_date,
        ]);
        return response()->json(['message' => 'Expense added successfully']);
    }
    public function show(string $id)
    {   // Fetch the expense by ID
        $expense = Expense::findOrFail($id);
        return response()->json($expense);
    }
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'amount' => 'required',
            'details' => 'required',
        ]);
        // Update the expense details
        $expense_update = Expense::findOrFail($id);
        $expense_update->update([
            'amount' => $request->amount,
            'details' => $request->details,
            'expense_date' => $request->expense_date,
        ]);
        return response()->json(['message' => 'Expense updated successfully']);
    }
    public function destroy(string $id)
    {
        // Delete the expense by ID
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return response()->json(['message' => 'Expense deleted successfully']);
    }
}
