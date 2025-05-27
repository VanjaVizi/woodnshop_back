<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KontaktPorukaController;
use App\Http\Controllers\ProizvodController;
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



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


// NEZAŠTIĆENE RUTE

Route::get('/proizvodi/kategorija/{kategorija}', [ProizvodController::class, 'byCategory']);


// ZAŠTIĆENE RUTE – npr. preko Sanctum middleware-a
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/proizvodi', [ProizvodController::class, 'store']);
    Route::put('/proizvodi/{id}', [ProizvodController::class, 'update']);
    Route::delete('/proizvodi/{id}', [ProizvodController::class, 'destroy']);
    Route::get('/proizvodi', [ProizvodController::class, 'index']);
    Route::get('/proizvodi/{id}', [ProizvodController::class, 'show']);
});


Route::post('/kontakt', [KontaktPorukaController::class, 'store']);
Route::get('/kontakt', [KontaktPorukaController::class, 'index']);  