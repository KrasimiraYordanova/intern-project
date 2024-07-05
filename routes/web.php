<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsNotAdmin;
use App\Http\Controllers\PropertyController;
use App\Models\Property;


// COMMON GUEST ROUTE
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
Route::get('/dashboard', [DashboardController::class, 'carsAndPropertiesByUser'])->middleware(['auth', 'verified', IsNotAdmin::class])->name('dashboard');

// ADMIN ROUTE
Route::get('/admin/dashboard', function () {
    return view('dashboard-admin');
})->middleware(['auth', 'verified', IsAdmin::class])->name('admin-dashboard');


// features:
// PROPERTY    // CAR    // USER
Route::group(['middleware' => ['auth', 'verified', IsAdmin::class]], function () {
    Route::get('/admin/properties', [PropertyController::class, 'index'])->name('admin.property.index');
    Route::get('/admin/property/{property}', [PropertyController::class, 'show'])->name('admin.property.detail');
    Route::post('/admin/delete/property/{property}', [PropertyController::class, 'destroy'])->name('admin.property.destroy');

    Route::get('/admin/cars', [CarController::class, 'index'])->name('admin.car.index');
    Route::get('/admin/car/{car}', [CarController::class, 'show'])->name('admin.car.detail');
    Route::post('/admin/delete/car/{car}', [CarController::class, 'destroy'])->name('admin.car.destroy');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.user.index');
    Route::view('/admin/user/create', 'admin.user.create')->name('admin.user.create');
    Route::get('/admin/user/{user}', [UserController::class, 'show'])->name('admin.user.detail');
    Route::get('/admin/user/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::post('/admin/user/store', [UserController::class, 'store'])->name('admin.user.store');
    Route::put('/admin/user/{user}', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/admin/delete/user/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
});

Route::group(['middleware' => ['auth', 'verified', IsNotAdmin::class]], function () {
    Route::get('/user/properties', [UserController::class, 'propertiesByUser'])->name('user.property.index');

    Route::view('/user/property/create', 'user.property.create')->name('user.property.create');
    Route::get('/user/property/{property}', [PropertyController::class, 'show'])->name('user.property.detail');
    Route::get('/user/property/{property}/edit', [PropertyController::class, 'edit'])->name('user.property.edit');
    Route::post('/user/property/store', [PropertyController::class, 'store'])->name('user.property.store');
    Route::put('/user/property/{property}', [PropertyController::class, 'update'])->name('user.property.update');
    Route::post('/user/delete/property/{property}', [PropertyController::class, 'destroy'])->name('user.property.destroy');

    Route::get('/user/cars', [UserController::class, 'carsByUser'])->name('user.car.index');

    Route::view('/user/car/create', 'user.car.create')->name('user.car.create');
    Route::get('/user/car/{car}', [CarController::class, 'show'])->name('user.car.detail');
    Route::get('/user/car/{car}/edit', [CarController::class, 'edit'])->name('user.car.edit');
    Route::post('/user/car/store', [CarController::class, 'store'])->name('user.car.store');
    Route::put('/user/car/{car}', [CarController::class, 'update'])->name('user.car.update');
    Route::post('/user/delete/car/{car}', [CarController::class, 'destroy'])->name('user.car.destroy');

});

// Route::put('/user/user', [UserController::class, 'addItemToUser'])->name('user.property.addItem');

require __DIR__ . '/auth.php';
