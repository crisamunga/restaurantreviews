<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('profile', ProfileController::class)->only(['index', 'store']);
    Route::apiResource('reviews', ReviewController::class)->except('update');
    Route::apiResource('restaurants', RestaurantController::class);
    Route::apiResource('users', UserController::class);
    Route::post("/reviews/{review}/remove_comment", [ReviewController::class, "uncomment"]);
    Route::post("/reviews/{review}/reply", [ReviewController::class, "reply"]);
});
