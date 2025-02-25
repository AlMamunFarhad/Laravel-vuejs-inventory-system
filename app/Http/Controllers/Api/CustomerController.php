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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = DB::table('customers')->get();
        return response()->json($customers);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'email',
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
            $img_path = "backend/customer/" . $rename_img;
            $img->save($img_path);
            // Store the Customer details
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->photo = $img_path;
            $customer->save();
        } else {
            // Store the Customer details
            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = DB::table('customers')->where('id',$id)->first();
        return response()->json($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $customer = Customer::where('id', $id)->first();

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
            // Store the Customer details
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->photo = $img_path;
            $customer->save();
        } else {
            // Store the Customer details
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::where('id', $id)->first();
        if (!empty($customer->photo) && file_exists(public_path($customer->photo))) {
            unlink(public_path($customer->photo));
        }
        $customer->delete();
    }
}
