<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post("/contactForm",'App\Http\Controllers\Admin@contactForm');
Route::post("/emailForm",'App\Http\Controllers\Admin@emailForm');
Route::post("/downloadForm",'App\Http\Controllers\Admin@downloadForm');
Route::post("/advisoryForm",'App\Http\Controllers\Admin@advisoryForm');
Route::post("/partnershipForm",'App\Http\Controllers\Admin@partnershipForm');
Route::post("/emailFormC",'App\Http\Controllers\Admin@emailFormC');
Route::post("/resourceForm",'App\Http\Controllers\Admin@resourceForm');
Route::post("/FreeTrail",'App\Http\Controllers\Admin@FreeTrail');

