<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
// use App\Models\User;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    $users = DB::table('users')->get();
    return view('dashboard',compact('users'));
})->name('dashboard');

// กำหนดสิทธิ์เข้าถึงข้อมูลด้วย Middleware
Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    // Department
    Route::get('/department/all',[DepartmentController::class, 'index'])->name('department');
    Route::post('/department/add',[DepartmentController::class, 'store'])->name('addDepartment');
    Route::get('/departments/edit/{id}', [DepartmentController::class, 'edit']);
    Route::post('/departments/update/{id}', [DepartmentController::class, 'update']);
    Route::get('/departments/softdelete/{id}', [DepartmentController::class, 'softdelete']);
    Route::get('/departments/restore/{id}', [DepartmentController::class, 'restore']);
    Route::get('/departments/delete/{id}', [DepartmentController::class, 'delete']);

    // Service
    Route::get('/service/all',[ServiceController::class, 'index'])->name('services');
    Route::post('/service/add',[ServiceController::class, 'store'])->name('addService');
});


