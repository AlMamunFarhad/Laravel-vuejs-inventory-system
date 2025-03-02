<?php

use App\Models\Salary;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\ExpenseCotroller;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;


Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});
// Resource Controller
Route::apiResource('/employee', EmployeeController::class);
Route::apiResource('/supplier', SupplierController::class);
Route::apiResource('/category', CategoryController::class);
Route::apiResource('/product', ProductController::class);
Route::apiResource('/expense', ExpenseCotroller::class);
Route::apiResource('/customer', CustomerController::class);

Route::post('/salary/paid/{id}', [SalaryController::class, 'salaryPaid']);
Route::get('/salary', [SalaryController::class, 'salaries']);
Route::get('/salary/view/{id}', [SalaryController::class, 'viewSalary']);
Route::get('/edit/salary/{id}', [SalaryController::class, 'editSalary']);
Route::put('/update/salary/{id}', [SalaryController::class, 'updateSalary']);
Route::put('/update/stock/{id}', [ProductController::class, 'updateStock']);

Route::get('/getting/product/{id}', [PosController::class, 'productByCategory']);
