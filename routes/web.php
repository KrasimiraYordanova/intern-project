<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\PropertyController;
use App\Models\User;

// COMMON ROUTE
Route::get('/', function () {
    return view('welcome');
});


// AUTH USERS AND ADMINS ROUTE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// USER ROUTE
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ADMIN ROUTE
Route::get('/admin/dashboard', function () {
    return view('dashboard-admin');
})->middleware(['auth', 'verified', IsAdmin::class])->name('admin-dashboard');

// features:
    // PROPERTY    // CAR    // USER
Route::get('/admin/properties', [PropertyController::class, 'index'])->name('property.index');
Route::get('/admin/users', [UserController::class, 'index'])->name('user.index');
Route::get('/admin/cars', [CarController::class, 'index'])->name('car.index');

Route::view('/admin/property/create', 'admin.property.create')->name('property.create');
Route::view('/admin/user/create', 'admin.user.create')->name('user.create');
Route::view('/admin/car/create', 'admin.car.create')->name('car.create');

Route::get('/admin/property/{property}', [PropertyController::class, 'show'])->name('property.detail');
Route::get('/admin/user/{user}', [UserController::class, 'show'])->name('user.detail');
Route::get('/admin/car/{car}', [CarController::class, 'show'])->name('car.detail');

Route::get('/admin/property/{property}/edit', [PropertyController::class, 'edit'])->name('property.edit');

Route::post('/admin/property/store', [PropertyController::class, 'store'])->name('property.store');
Route::post('/admin/user/store', [UserController::class, 'store'])->name('user.store');
Route::post('/admin/car/store', [CarController::class, 'store'])->name('car.store');

Route::put('/admin/property/{property}', [PropertyController::class, 'update'])->name('property.update');
Route::delete('/admin/delete?{property}', [PropertyController::class, 'destroy'])->name('property.destroy');

require __DIR__.'/auth.php';
