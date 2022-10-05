<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [UploadController::class, 'uploadForm']); 

Route::post('/upload', [UploadController::class, 'uploadFile'])->name('upload'); //(sätta ->name är bra så man slipper ändra url)

Route::post('/photos', [ApiController::class, 'generateImage'])->name('apiUpload');





