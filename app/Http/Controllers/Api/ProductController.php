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
    public function index()
    {
        // Fetch all products with their category and supplier
        $products = Product::with(['category', 'supplier'])->orderBy('id', 'desc')->get();
        return response()->json($products);
    }
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
        // Check if the request has an image
        if ($image) {
            $ext = explode('/', explode(':', $image)[1])[1];
            $ext = explode(';', $ext)[0];
            $rename_img = time() . "." . $ext;
            $manager = new ImageManager(new Driver());
            $img =  $manager->read($image);
            $img->cover(300, 200);
            $img_path = "backend/product/" . $rename_img;
            $img->save($img_path);
            // Save the product with the image path
            Product::create([
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
            // If no image is provided, set a default image path
            Product::create([
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
    public function show(string $id)
    {
        // Show a single product 
        $product = $product = Product::findOrFail($id);
        return response()->json($product);
    }
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $vaidateData = $request->validate([
            'category_id' => 'required',
            'supplier_id' => 'required',
            'product_code' => 'nullable',
            'product_name' => 'required',
            'selling_price' => 'required',
            'product_quantity' => 'required',
        ]);
        $product = Product::findOrFail($id);
        $old_photo = $product->image;
        // Save the new image
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
        // update the product
        $product->update([
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
        return response()->json([
            'message' => 'Product updated successfully!',
            'image' => asset($product->image),
        ]);
    }
    // Update Product Stock
    public function updateStock(Request $request, string $id)
    {
        $vaidateData = $request->validate([
            'product_quantity' => 'required',
        ]);
        $product = Product::findOrFail($id);
        $product->update([
            'product_quantity' => $request->product_quantity,
        ]);
    }
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        // Check if the image exists and delete it
        if (!empty($product->image && file_exists(public_path($product->image)))) {
            unlink(public_path($product->image));
        }
        $product->delete();
    }
}
