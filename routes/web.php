<?php

use App\Http\Controllers\JiebaController;
use Illuminate\Support\Facades\Route;

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
Route::get('/jieba', [JiebaController::class, 'index']);
Route::post('/jieba', [JiebaController::class, 'process']);
