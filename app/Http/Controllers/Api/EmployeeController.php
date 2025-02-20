<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
// use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class EmployeeController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'salary' => 'required',
        ]);

        $photo = $request->photo;
        if ($photo) {
            $ext = explode('/', explode(':', $photo)[1])[1];
            $ext = explode(';', $ext)[0];
            $rename_img = time() . "." . $ext;
            $manager = new ImageManager(new Driver());
            $img =  $manager->read($photo);
            $img->cover(300, 200);
            $img_path = "backend/employee/" . $rename_img;
            $img->save($img_path);
            // Store the employee details
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->photo = $img_path;
            $employee->joining_date = $request->joining_date;
            $employee->save();
        } else {
            // Store the employee details
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->joining_date = $request->joining_date;
            $employee->save();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = DB::table('employees')->where('id', $id)->first();
        return response()->json($employee);
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
        // Employee Update Validation
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'salary' => 'required',
        ]);

        $employee = Employee::findOrFail($id);
        $old_photo = $employee->photo;
        // Update the employee photo
        if ($request->photo && strpos($request->photo, 'data:image') === 0) {
            $ext = explode('/', explode(':', $request->photo)[1])[1];
            $ext = explode(';', $ext)[0];
            $rename_img = time() . "." . $ext;
            $img_path = "backend/employee/" . $rename_img;

            $manager = new ImageManager(new Driver());
            $img = $manager->read($request->photo);
            $img->cover(300, 200);
            $img->save($img_path);

            if (file_exists($old_photo)) {
                unlink($old_photo);
            }

            $employee->photo = $img_path; 
        } else {
            $employee->photo = $old_photo; 
        }
        // Update the employee details
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->nid = $request->nid;
        $employee->joining_date = $request->joining_date;

        $employee->save();

        return response()->json([
            'message' => 'Employee updated successfully!',
            'photo' => asset( $employee->photo),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::where('id', $id)->first();
        if (!empty($employee->photo) && file_exists(public_path($employee->photo))) {
            unlink(public_path($employee->photo));
        }
        $employee->delete();
    }
}
