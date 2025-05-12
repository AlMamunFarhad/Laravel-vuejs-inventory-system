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
    public function index()
    {
        // Fetch all employees from the database
        $employee = Employee::all();
        return response()->json($employee);
    }
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'salary' => 'required',
        ]);
        // Create a new employee
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
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'salary' => $request->salary,
                'nid' => $request->nid,
                'photo' => $img_path,
                'joining_date' => $request->joining_date,
            ]);
        } else {
            // Store the employee details without photo
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'salary' => $request->salary,
                'nid' => $request->nid,
                'joining_date' => $request->joining_date,
            ]);
        }
    }
    public function show(string $id)
    {
        // Fetch the employee details from the database
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }
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
        // Check if the employee exists
        $employee = Employee::findOrFail($id);
        // Upload the employee photo
        $old_photo = $employee->photo;
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
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'salary' => $request->salary,
            'nid' => $request->nid,
            'joining_date' => $request->joining_date,
        ]);
        return response()->json([
            'message' => 'Employee updated successfully!',
            'photo' => asset($employee->photo),
        ]);
    }
    public function destroy(string $id)
    {
        $employee = Employee::where('id', $id)->first();
        if (!empty($employee->photo) && file_exists(public_path($employee->photo))) {
            unlink(public_path($employee->photo));
        }
        $employee->delete();
    }
}
