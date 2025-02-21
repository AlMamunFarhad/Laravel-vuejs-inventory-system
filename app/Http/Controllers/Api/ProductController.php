<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = DB::table('products')
        ->join('categories', 'products.category_id', 'categories.id')
        ->join('suppliers', 'products.supplier_id', 'suppliers.id')
        ->select('categories.category_name', 'suppliers.name', 'products.*')
        ->orderBy('products.id', 'desc')
        ->get();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vaidateData = $request->validate([
            'category_id' => 'required',
            'supplier_id' => 'required',
            'product_code' => 'nullable',
            'product_name' => 'required',
            'selling_price' => 'required',
            'product_quantity' => 'required',
        ]);

        $image = $request->image;
        if ($image) {
            $ext = explode('/', explode(':', $image)[1])[1];
            $ext = explode(';', $ext)[0];
            $rename_img = time() . "." . $ext;
            $manager = new ImageManager(new Driver());
            $img =  $manager->read($image);
            $img->cover(300, 200);
            $img_path = "backend/product/" . $rename_img;
            $img->save($img_path);

            $product = DB::table('products')->insert([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'product_name' => $request->product_name,
                'product_code' => $request->product_code,
                'root' => $request->root,
                'buying_price' => $request->buying_price,
                'selling_price' => $request->selling_price,
                'buying_date' => $request->buying_date,
                'product_quantity' => $request->product_quantity,
                'image' => $img_path,
            ]);
        } else {
            $product = DB::table('products')->insert([
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'product_name' => $request->product_name,
                'product_code' => $request->product_code,
                'root' => $request->root,
                'buying_price' => $request->buying_price,
                'selling_price' => $request->selling_price,
                'buying_date' => $request->buying_date,
                'product_quantity' => $request->product_quantity,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vaidateData = $request->validate([
            'category_id' => 'required',
            'supplier_id' => 'required',
            'product_code' => 'nullable',
            'product_name' => 'required',
            'selling_price' => 'required',
            'product_quantity' => 'required',
        ]);

        // $product = DB::table('products')->where('id',$id)->first();
        $product = Product::findOrFail($id);
        $old_photo = $product->image;
        // dd($old_photo);
        // Update the employee photo
        if ($request->photo && strpos($request->photo, 'data:image') === 0) {
            $ext = explode('/', explode(':', $request->photo)[1])[1];
            $ext = explode(';', $ext)[0];
            $rename_img = time() . "." . $ext;
            $img_path = "backend/product/" . $rename_img;

            $manager = new ImageManager(new Driver());
            $img = $manager->read($request->photo);
            $img->cover(300, 200);
            $img->save($img_path);

            if (file_exists($old_photo)) {
                unlink($old_photo);
            }

            $product->image = $img_path; 
        } else {
            $product->image = $old_photo; 
        }

        $product->product_id = $request->category_id;
        $product->supplier_id = $request->supplier_id;
        $product->product_name = $request->product_name;
        $product->product_code = $request->product_code;
        $product->root = $request->root;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->buying_date = $request->buying_date;
        $product->product_quantity = $request->product_quantity;

        return response()->json([
            'message' => 'Product updated successfully!',
            'image' => asset( $product->image),
       ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if(!empty($product->image && file_exists(public_path($product->image)))) {
            unlink(public_path($product->image));
        }
        DB::table('products')->where('id', $id)->delete();
    }
}
