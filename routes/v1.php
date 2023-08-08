<?php

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

Route::post('register', [v1Controller::class, 'registerUser'])->name('user.register');

/**
 * sudah login:
 * Update User
 * Delete User
 * Detail User
 *
 */
