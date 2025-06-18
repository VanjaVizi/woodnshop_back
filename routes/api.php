<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CenovnikController;
use App\Http\Controllers\KontaktPorukaController;
use App\Http\Controllers\ProizvodController;
use App\Http\Controllers\KategorijaController;
use App\Http\Controllers\NarudzbinaController;

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
Route::post('/narudzbine', [NarudzbinaController::class, 'store']);

Route::get('/kategorije', [KategorijaController::class, 'index']);
Route::get('/kategorije/{slug}', [KategorijaController::class, 'showBySlug']);
   Route::get('/kategorije/slug/{slug}', [KategorijaController::class, 'showBySlug']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


 Route::get('/proizvodi/{proizvod_id}/cenovnici', [CenovnikController::class, 'index']);
Route::get('/proizvodi/kategorija/{kategorija}', [ProizvodController::class, 'byCategory']);
Route::get('/proizvodi/naziv/{naziv}', [ProizvodController::class, 'showByNaziv']);
    Route::get('/proizvodi', [ProizvodController::class, 'index']);
    Route::get('/proizvodi/{id}', [ProizvodController::class, 'show']);
Route::post('/kontakt', [KontaktPorukaController::class, 'store']);
Route::get('/proizvodi/{id}/naziv-kategorija', [ProizvodController::class, 'nazivIKategorija']);
// ZAŠTIĆENE RUTE – samo admin
Route::middleware('auth:sanctum')->group(function () {





    Route::post('/proizvodi', [ProizvodController::class, 'store']);
    Route::put('/proizvodi/{id}', [ProizvodController::class, 'update']);
    Route::delete('/proizvodi/{id}', [ProizvodController::class, 'destroy']);
    Route::delete('/proizvodi/{id}/slika/{index}', [ProizvodController::class, 'deleteImage']);
    Route::post('/proizvodi/{id}/reorder-slike', [ProizvodController::class, 'reorderImages']);



        Route::post('/cenovnici', [CenovnikController::class, 'store']);
        Route::put('/cenovnici/{id}', [CenovnikController::class, 'update']);
        Route::delete('/cenovnici/{id}', [CenovnikController::class, 'destroy']);

 
    Route::post('/kategorije', [KategorijaController::class, 'store']);
    Route::put('/kategorije/{id}', [KategorijaController::class, 'update']);
    Route::delete('/kategorije/{id}', [KategorijaController::class, 'destroy']);


    Route::get('/kontakt', [KontaktPorukaController::class, 'index']);  

});
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


