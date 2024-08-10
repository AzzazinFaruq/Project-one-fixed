<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\AppController;
use App\Http\Controllers\PendudukCon;
use App\Http\Controllers\constCon;
use App\Http\Controllers\keluargaCon;
use App\Http\Controllers\universalCon as univ;


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
    Route::put('/update/{id}', [AppController::class, 'userUpdate']);
    Route::get('/userDt', [AppController::class, 'userData']);
    //PENDUDUK API
    Route::get('/penduduk', [PendudukCon::class,'getPenduduk']);
    Route::get('/latestpen', [PendudukCon::class,'latest']);
    Route::get('/byID/{id}', [PendudukCon::class,'getbyID']);
    Route::get('/penduduk/{id}', [PendudukCon::class,'showPenduduk']);
    Route::put('/updatePenduduk/{id}', [PendudukCon::class,'updatePenduduk']);
    Route::get('/dtcon', [constCon::class,'index']);
    Route::post('/addPenduduk',[PendudukCon::class,"addPenduduk"]);
    Route::delete('/deletePenduduk/{id}', [PendudukCon::class, 'destroy']);
    //KELUARGA API
    Route::get('/keluarga', [keluargaCon::class, 'index']);
    Route::get('/keluargaidx', [keluargaCon::class, 'get']);
    Route::get('/latestkel', [keluargaCon::class, 'latest']);
    Route::get('/keluarga/{id}', [keluargaCon::class, 'getByID']);
    Route::get('/kel/{id}', [keluargaCon::class, 'ByID']);
    Route::post('/addKeluarga', [keluargaCon::class, 'addKeluarga']);
    Route::put('/editKeluarga/{id}', [keluargaCon::class, 'update']);
    Route::delete('/deleteKeluarga/{id}', [keluargaCon::class, 'destroy']);

    //LAIN-LAIN
    Route::get('/jumlah', [univ::class, 'dataCount']);
    Route::get('/alive', [univ::class, 'aliveCount']);
    Route::get('/marry', [univ::class, 'marryCount']);
    Route::get('/gender', [univ::class, 'genderCount']);
    Route::get('/data', [univ::class, 'rangeData']);




});

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });
