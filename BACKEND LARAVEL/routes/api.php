<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\AppController;
use App\Http\Controllers\PendudukCon;
use App\Http\Controllers\constCon;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AppController::class, 'user']);
    Route::get('/penduduk', [PendudukCon::class,'getPenduduk']);
    Route::get('/penduduk/{id}', [PendudukCon::class,'showPenduduk']);
    Route::put('/updatePenduduk/{id}', [PendudukCon::class,'updatePenduduk']);
    Route::get('/dtcon', [constCon::class,'index']);
    Route::post('/addPenduduk',[PendudukCon::class,"addPenduduk"]);
    Route::delete('/deletePenduduk/{id}', [PendudukCon::class, 'destroy']);



});

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
