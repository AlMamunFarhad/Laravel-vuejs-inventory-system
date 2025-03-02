<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PosController extends Controller
{
    public function productByCategory($id)
    {
        $product = DB::table('products')->where('category_id', $id)->get();
        return response()->json($product);
    }
}
