<?php

use App\Http\Controllers\V1\AuthController;
use Illuminate\Support\Facades\Route;

/**
 * ------------------------
 * Buat API end point
 * ------------------------
 * belum login:
 * register user ( first target )
 * Login
 * list semua data user
 * pagination
 * filter based on street
 */

Route::post('register', [AuthController::class, 'register'])->name('user.register');
Route::post('login', [AuthController::class, 'login'])->name('user.login');

/**
 * sudah login:
 * Update User
 * Delete User
 * Detail User
 *
 */
