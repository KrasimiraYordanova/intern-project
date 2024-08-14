<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UsersCarsController;
use App\Http\Controllers\UsersPropertiesController;

// COMMON GUEST ROUTE
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'allCarsPropertiesUsers'])->middleware(['auth', 'verified'])->name('dashboard');


// ADMIN ROUTS
Route::group(['middleware' => ['auth', 'verified', IsAdmin::class]], function () {

    // ADMIN -> ALL CRUD OPERATIONS ON CAR
    Route::get('/car/create', [CarController::class, 'create'])->name('car.create');
    Route::get('/car/{carId}/edit', [CarController::class, 'edit'])->name('car.edit');
    Route::post('/car/store', [CarController::class, 'store'])->name('car.store');
    Route::put('/car/{carId}', [CarController::class, 'update'])->name('car.update');

    // ADMIN -> ALL CRUD OPERATIONS ON PROPERTY
    Route::get('/property/create', [PropertyController::class, 'create'])->name('property.create');
    Route::get('/property/{propertyId}/edit', [PropertyController::class, 'edit'])->name('property.edit');
    Route::post('/property/store', [PropertyController::class, 'store'])->name('property.store');
    Route::put('/property/{propertyId}', [PropertyController::class, 'update'])->name('property.update');

    Route::get('/user/{userId}/car/{carId}/{carAttUuid}', [UsersCarsController::class, 'getUsersCar'])->name('user.car');
    Route::get('/user/{userId}/properties/{propertyId}/{propertyAttUuid}', [UsersPropertiesController::class, 'getUsersProperty'])->name('user.property');

    // ADMIN -> ALL CRUD OPERATIONS ON USER
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'user.create'])->name('user.create');
    Route::get('/user/{userId}', [UserController::class, 'show'])->name('user.detail');
    Route::get('/user/{userId}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::put('/user/{userId}', [UserController::class, 'update'])->name('user.update');
    Route::get('/deleteconfirmation/user/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('/delete/user/{userId}', [UserController::class, 'destroy'])->name('user.destroy');
});

// COMMON ROUTS -> INDEX + DETAILS + ATTACH AND DETACH ITEM
Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/cars', [CarController::class, 'index'])->name('car.index');
    Route::get('/car/{carId}', [CarController::class, 'show'])->name('car.detail');
    Route::get('/deleteconfirmation/car/{id}', [CarController::class, 'delete'])->name('car.delete');
    Route::get('/deleteconfirmation/car/{id}', [CarController::class, 'delete'])->name('car.deleteCar');
    Route::post('/delete/car/{carId}', [CarController::class, 'destroy'])->name('car.destroy');

    Route::get('/properties', [PropertyController::class, 'index'])->name('property.index');
    Route::get('/property/{propertyId}', [PropertyController::class, 'show'])->name('property.detail');
    Route::get('/deleteconfirmation/property/{id}', [PropertyController::class, 'delete'])->name('property.delete');
    Route::get('/deleteconfirmation/property/{id}', [PropertyController::class, 'delete'])->name('property.deleteProperty');
    Route::post('/delete/property/{propertyId}', [PropertyController::class, 'destroy'])->name('property.destroy');

    Route::get('/delete/user/{userId}/car/{carId}', [UsersCarsController::class, 'detachUsersCar'])->name('car.detach');
    Route::get('/delete/user/{userId}/property/{propertyId}', [UsersPropertiesController::class, 'detachUsersProperty'])->name('property.detach');
});

// USER ROUTS -> ATTACH ITEM
Route::group(['middleware' => ['auth', 'verified', IsAdmin::class]], function () {

    Route::get('/add/car/{carId}', [CarController::class, 'attachCar'])->name('attach.car');
    Route::get('/add/property/{propertyId}', [PropertyController::class, 'attachProperty'])->name('attach.property');
});

Route::fallback(function () {
    return view('notFound');
});


require __DIR__ . '/auth.php';
