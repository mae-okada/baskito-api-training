<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\UserController;
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

Route::get('users', [UserController::class, 'index'])->name('user.list');
Route::get('users/search', [UserController::class, 'search'])->name('user.search');

/**
 * sudah login:
 * Update User
 * Delete User
 * Detail User
 */

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('update', [UserController::class, 'update'])->name('user.update');
    Route::delete('delete', [UserController::class, 'delete'])->name('user.delete');
    Route::get('detail', [UserController::class, 'userDetail'])->name('user.detail');
});
