<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

// То, что автоматом сгенерировалось, я не стал убирать
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/news/item/{id}', [NewsController::class, 'getNewsItem']);
Route::get('/news/list/{pageNum}', [NewsController::class, 'getNewsList']);
