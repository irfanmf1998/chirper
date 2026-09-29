<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;

// Route Halaman Utama
//Route::get('/', function () {
    //return view('welcome');
//});
Route::get('/', [ChirpController::class, 'index']);

// Route untuk menampilkan halaman login
Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('/login', Login::class)
    ->middleware('guest');

// Route untuk menampilkan halaman register
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');

Route::post('/register', Register::class)
    ->middleware('guest');

// Route untuk logout pengguna yang sudah login
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');

// Protected routes (NEW)
Route::middleware('auth')
    ->group(function () {
        Route::resource('chirps', ChirpController::class)
        ->only(['store', 'edit', 'update', 'destroy']);    
    });

// Route untuk menampilkan halaman pencarian
Route::get('/search', [ChirpController::class, 'search']);

//////          User Page         //////

// Route profil pengguna yang hanya dapat diakses oleh pengguna yang sudah login
Route::get('/my-page', [ChirpController::class, 'myPage'])
    ->middleware('auth');

// Route profil pengguna lain yang dapat diakses oleh semua pengguna
Route::get('/user/{id}', [ChirpController::class, 'userProfile']);

//////          Follow/Unfollow System          //////

// Route untuk mengikuti pengguna lain
// Route::get('/user/{id}/follow', [ChirpController::class, 'followOvertrue'])->middleware('auth');
Route::get('/user/{id}/follow', [ChirpController::class, 'follow'])->middleware('auth');

// Route untuk berhenti mengikuti pengguna lain
// Route::get('/user/{id}/unfollow', [ChirpController::class, 'unfollowOvertrue'])->middleware('auth');
Route::get('/user/{id}/unfollow', [ChirpController::class, 'unfollow'])->middleware('auth');