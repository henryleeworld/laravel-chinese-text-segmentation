<?php

use App\Http\Controllers\JiebaController;
use Illuminate\Support\Facades\Route;

Route::get('/jieba', [JiebaController::class, 'index']);
Route::post('/jieba', [JiebaController::class, 'process']);
