<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

/**
 * Сначала я не обратил особого внимания и сделал
 * Route::get('/news/item/{id}', [NewsController::class, 'getNewsItem']);
 *
 * Мне так было привычнее, так как легче отслеживать было, а потом уже заменил
 */

Route::get('/news/', [NewsController::class, 'getNews']);
