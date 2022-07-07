<?php

use App\Http\Controllers\API\PersonneController;
use App\Http\Controllers\API\TravelController;
use App\Http\Controllers\API\TypeController;
use App\Http\Controllers\API\VehiculeController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource("personnes", PersonneController::class);
Route::apiResource("types", TypeController::class);
Route::apiResource("vehicules", VehiculeController::class);
Route::apiResource("travels", TravelController::class);
