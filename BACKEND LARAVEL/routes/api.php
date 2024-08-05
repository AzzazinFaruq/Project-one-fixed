<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\AppController;
use App\Http\Controllers\PendudukCon;
use App\Http\Controllers\constCon;
use App\Http\Controllers\keluargaCon;


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
    //USER API
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AppController::class, 'user']);
<<<<<<< HEAD
    Route::put('/user-update/{id}', [AppController::class, 'userUpdate']);
=======
    Route::get('/userDt', [AppController::class, 'userData']);
>>>>>>> 012f50bff2332158689606eefa678a48360a8b95
    Route::get('/userAll', [AppController::class, 'index']);
    //PENDUDUK API
    Route::get('/penduduk', [PendudukCon::class,'getPenduduk']);
    Route::get('/byID/{id}', [PendudukCon::class,'getbyID']);
    Route::get('/penduduk/{id}', [PendudukCon::class,'showPenduduk']);
    Route::put('/updatePenduduk/{id}', [PendudukCon::class,'updatePenduduk']);
    Route::get('/dtcon', [constCon::class,'index']);
    Route::post('/addPenduduk',[PendudukCon::class,"addPenduduk"]);
    Route::delete('/deletePenduduk/{id}', [PendudukCon::class, 'destroy']);
    //KELUARGA API
    Route::get('/keluarga', [keluargaCon::class, 'index']);
    Route::get('/keluarga/{id}', [keluargaCon::class, 'getByID']);
    Route::post('/addKeluarga', [keluargaCon::class, 'addKeluarga']);
    Route::put('/editKeluarga/{id}', [keluargaCon::class, 'update']);
    Route::delete('/deleteKeluarga/{id}', [keluargaCon::class, 'destroy']);



});

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
