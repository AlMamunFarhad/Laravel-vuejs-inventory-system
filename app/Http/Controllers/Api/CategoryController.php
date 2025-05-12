<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::all();
        return response()->json($categories);
    }
    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $validate = $request->validate([
            'category_name' => 'required',
        ]);
        $category = Category::create([
            'category_name' => $request->category_name
        ]);
        return response()->json($category);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the category by ID
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'category_name' => 'required',
        ]);
        // Update the category details
        $category = Category::findOrFail($id);
        $category->update([
            'category_name' => $request->category_name
        ]);
        return response()->json($category);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the category by ID
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
}
