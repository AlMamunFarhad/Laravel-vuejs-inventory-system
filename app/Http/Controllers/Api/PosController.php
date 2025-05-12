<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product;

class PosController extends Controller
{
    public function productByCategory($id)
    {
        // Fetch all products for the given category ID
        $product = Product::where('category_id', $id)->get();
        return response()->json($product);
    }
}
