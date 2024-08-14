<?php
/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="This is the API documentation for my application",
 *     @OA\Contact(
 *         email="your-email@example.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Server(
 *     url="http://localhost/api",
 *     description="Local server"
 * )
 *
 * @OA\Server(
 *     url="https://api.example.com",
 *     description="Production server"
 * )
 * 
 *
 * 
 */

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CarControllerAPI;
use App\Http\Controllers\PropertyControllerAPI;
use App\Http\Controllers\UserControllerAPI;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);

Route::get('/users', [UserControllerAPI::class, 'index'])->middleware(['auth:sanctum', IsAdmin::class]);
Route::get('/user/{id}', [UserControllerAPI::class, 'show'])->middleware(['auth:sanctum', IsAdmin::class]);
Route::post('/users', [UserControllerAPI::class, 'store'])->middleware(['auth:sanctum', IsAdmin::class]);
Route::put('/user/{id}', [UserControllerAPI::class, 'update'])->middleware(['auth:sanctum', IsAdmin::class]);
Route::delete('/user/{id}', [UserControllerAPI::class, 'destroy'])->middleware(['auth:sanctum', IsAdmin::class]);

Route::get('/cars', [CarControllerAPI::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/car/{id}', [CarControllerAPI::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/cars', [CarControllerAPI::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/car/{id}', [CarControllerAPI::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/car/{id}', [CarControllerAPI::class, 'destroy'])->middleware(['auth:sanctum']);

Route::get('/properties', [PropertyControllerAPI::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/property/{id}', [PropertyControllerAPI::class, 'show'])->middleware(['auth:sanctum']);
Route::post('/properties', [PropertyControllerAPI::class, 'store'])->middleware(['auth:sanctum']);
Route::put('/property/{id}', [PropertyControllerAPI::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/property/{id}', [PropertyControllerAPI::class, 'destroy'])->middleware(['auth:sanctum']);

Route::post('/add/car/{carId}', [CarControllerAPI::class, 'attachCar'])->middleware(['auth:sanctum']);
Route::post('/delete/car/{carId}', [CarControllerAPI::class, 'destroy'])->middleware(['auth:sanctum']);

Route::post('/add/property/{propertyId}', [PropertyControllerAPI::class, 'attachProperty'])->middleware(['auth:sanctum']);
Route::post('/delete/property/{propertyId}', [PropertyControllerAPI::class, 'destroy'])->middleware(['auth:sanctum']);

Route::fallback(function () {
    return response()->json([
        'message' => 'Not found'
    ], 404);
});
