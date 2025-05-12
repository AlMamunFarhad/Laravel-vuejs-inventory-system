<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::get();
        return response()->json($suppliers); 
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $photo = $request->photo;
        if ($photo) {
            $ext = explode('/', explode(':', $photo)[1])[1];
            $ext = explode(';', $ext)[0];
            $rename_img = time() . "." . $ext;
            $manager = new ImageManager(new Driver());
            $img =  $manager->read($photo);
            $img->cover(300, 200);
            $img_path = "backend/supplier/" . $rename_img;
            $img->save($img_path);
            // Store the employee details
<<<<<<< HEAD
            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->shop_name = $request->shop_name;
            $supplier->photo = $img_path;
            $supplier->save();
=======
            // $supplier = new Supplier();
            // $supplier->name = $request->name;
            // $supplier->email = $request->email;
            // $supplier->phone = $request->phone;
            // $supplier->address = $request->address;
            // $supplier->shop_name = $request->shop_name;
            // $supplier->photo = $img_path;
            // $supplier->save();
            Supplier::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'shop_name' => $request->shop_name,
                'photo' => $img_path,
            ]);
>>>>>>> 68deda0 (Cleaned up duplicate commits and added updated code)
        } else {
            // Store the employee details
            // $supplier = new Supplier();
            // $supplier->name = $request->name;
            // $supplier->email = $request->email;
            // $supplier->phone = $request->phone;
            // $supplier->address = $request->address;
            // $supplier->shop_name = $request->shop_name;
            // $supplier->save();
            Supplier::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'shop_name' => $request->shop_name,
            ]);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $supplier = DB::table('suppliers')->where('id', $id)->first();
        $supplier = Supplier::findOrFail($id);
        return response()->json($supplier);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
                // Employee Update Validation
                $validateData = $request->validate([
                    'name' => 'required',
                    'email' => 'required|email',
                    'phone' => 'required',
                    'address' => 'required',
                ]);
        
                $supplier = Supplier::findOrFail($id);
                $old_photo = $supplier->photo;
                // Update the employee photo
                if ($request->photo && strpos($request->photo, 'data:image') === 0) {
                    $ext = explode('/', explode(':', $request->photo)[1])[1];
                    $ext = explode(';', $ext)[0];
                    $rename_img = time() . "." . $ext;
                    $img_path = "backend/supplier/" . $rename_img;
        
                    $manager = new ImageManager(new Driver());
                    $img = $manager->read($request->photo);
                    $img->cover(300, 200);
                    $img->save($img_path);
        
                    if (file_exists($old_photo)) {
                        unlink($old_photo);
                    }
        
                    $supplier->photo = $img_path; 
                } else {
                    $supplier->photo = $old_photo; 
                }
                // Update the employee details
                    // $supplier->name = $request->name;
                    // $supplier->email = $request->email;
                    // $supplier->phone = $request->phone;
                    // $supplier->address = $request->address;
                    // $supplier->shop_name = $request->shop_name;
                    // $supplier->save();
                    $supplier->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'shop_name' => $request->shop_name,
                    ]);
                    
                return response()->json([
                    'message' => 'Employee updated successfully!',
                    'photo' => asset( $supplier->photo),
                ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $supplier = DB::table('suppliers')->where('id', $id)->first();
        $supplier = Supplier::findOrFail($id);
        if(!empty($supplier->photo && file_exists(public_path($supplier->photo)))) {
            unlink(public_path($supplier->photo));
        }
        $supplier->delete();
    }
}
