<?php

use App\Http\Controllers\LinearController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LinearController::class, 'view_linear'])->name('view_linear');
Route::get('view_linear_post', [LinearController::class, 'view_linear_post'])->name('view_linear_post');
Route::get('chart', [LinearController::class, 'chart'])->name('chart');
