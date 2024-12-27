<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
Route::apiResource('users', UserController::class);

