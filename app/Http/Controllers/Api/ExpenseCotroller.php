<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ExpenseCotroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = DB::table('expenses')->get();
        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'amount' => 'required',
            'details' => 'required',
        ]);

        DB::table('expenses')->insert([
            'amount' => $request->amount,
            'details' => $request->details,
            'expense_date' => $request->expense_date,
    ]);

        return response()->json(['message' => 'Expense added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expense = DB::table('expenses')->where('id', $id)->find($id);
        return response()->json($expense);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'amount' => 'required',
            'details' => 'required',
        ]);

        DB::table('expenses')->where('id', $id)->update([
            'amount' => $request->amount,
            'details' => $request->details,
            'expense_date' => $request->expense_date,
        ]);

        return response()->json(['message' => 'Expense updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('expenses')->where('id', $id)->delete();
        return response()->json(['message' => 'Expense deleted successfully']);
    }
}
