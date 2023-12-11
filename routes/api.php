<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('/perusahaan', PerusahaanController::class);
Route::resource('/pendaftar', PendaftarController::class);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/admin', [LoginController::class, 'loginAdmin']);
Route::post('/perusahaanLog', [LoginController::class, 'loginPerusahaan']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');


Route::get('/filea/{filename}/{name}', 'App\Http\Controllers\fotoController@show');

Route::get('/file/{filename}/{name}', 'App\Http\Controllers\berkasController@show');

Route::get('/file/{filename}/{name}', 'App\Http\Controllers\pasFotoController@show');