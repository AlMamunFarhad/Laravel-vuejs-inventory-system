<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::all();
        return response()->json($categories);
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'category_name' => 'required',
        ]);
        // Create a new category
        $category = Category::create([
            'category_name' => $request->category_name
        ]);
        return response()->json($category);
    }
    public function show(string $id)
    {
        // Fetch the category by ID
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
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
    public function destroy(string $id)
    {
        // Delete the category by ID
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
}
