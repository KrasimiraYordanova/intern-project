<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard-admin', function () {
    return view('dashboard_admin');
})->middleware(['auth', 'verified', IsAdmin::class])->name('dashboard-admin');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// features:
    // PROPERTY    // CAR    // USER
Route::get('/admin/properties', [PropertyController::class, 'index'])->name('property.index');
Route::view('/admin/property/create', 'admin.property.create')->name('property.create');
Route::get('/admin/property/{property}', [PropertyController::class, 'show'])->name('property.detail');
Route::get('/admin/property/{property}/edit', [PropertyController::class, 'edit'])->name('property.edit');
Route::post('/admin/property/store', [PropertyController::class, 'store'])->name('property.store');
Route::put('/admin/property/{property}', [PropertyController::class, 'update'])->name('property.update');
Route::delete('/admin/delete?{property}', [PropertyController::class, 'destroy'])->name('property.destroy');

require __DIR__.'/auth.php';
