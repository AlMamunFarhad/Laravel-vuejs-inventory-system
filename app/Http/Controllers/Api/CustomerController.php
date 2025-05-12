<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CustomerController extends Controller
{
    public function index()
    {
        // Fetch all customers from the database
        $customers = Customer::get();
        return response()->json($customers);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'address' => 'required',
        ]);
        // Create a new customer
        $photo = $request->photo;
        if ($photo) {
            $ext = explode('/', explode(':', $photo)[1])[1];
            $ext = explode(';', $ext)[0];
            $rename_img = time() . "." . $ext;
            $manager = new ImageManager(new Driver());
            $img =  $manager->read($photo);
            $img->cover(300, 200);
            $img_path = "backend/customer/" . $rename_img;
            $img->save($img_path);
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $img_path
            ]);
        } else {
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }
    }
    public function show(string $id)
    {
        // Fetch the customer details from the database
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'address' => 'required',
        ]);
        // Update the customer details
        $customer = Customer::findOrFail($id);
        $photo = $request->photo;
        if ($request->photo && strpos($request->photo, 'data:image') === 0) {
            $ext = explode('/', explode(':', $photo)[1])[1];
            $ext = explode(';', $ext)[0];
            $rename_img = time() . "." . $ext;
            $manager = new ImageManager(new Driver());
            $img =  $manager->read($photo);
            $img->cover(300, 200);
            $img_path = "backend/customer/" . $rename_img;
            $img->save($img_path);
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'photo' => $img_path
            ]);
        } else {
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

    }
    public function destroy(string $id)
    {
        // Delete the customer by ID
        $customer = Customer::where('id', $id)->first();
        if (!empty($customer->photo) && file_exists(public_path($customer->photo))) {
            unlink(public_path($customer->photo));
        }
        $customer->delete();
    }
}
