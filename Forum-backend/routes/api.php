<?php

use App\Http\Controllers\PostApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// routes/api.php



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::controller(PostApiController::class)->group(function () {
    Route::get('/posts', 'index')->name('index');
    Route::post('/posts/create', 'store')->name('create');
    Route::get('/post/{id}', 'show')->name('show');
    Route::delete('/post/{id}', 'delete')->name('delete');
    Route::put('/post/{id}', 'update')->name('update');
    Route::get('/comments', 'index')->name('index');
    Route::post('/comments/create', 'store')->name('create');
    Route::get('/comment/{id}', 'show')->name('show');
    Route::delete('/comment/{id}', 'delete')->name('delete');
    Route::put('/comment/{id}', 'update')->name('update');
});

