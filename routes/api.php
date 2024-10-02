<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:user')->group(function() {
  Route::post('logout', [AuthController::class, 'logout'])->name('logout');

  Route::prefix('/profiles')->name('profile.')->group(function() {
    Route::get('/{id}', [ProfileController::class, 'show'])->name('show');
    Route::post('/', [ProfileController::class, 'store'])->name('store');
    Route::post('/update', [ProfileController::class, 'update'])->name('update');
  });

  Route::prefix('/posts')->name('post.')->group(function() {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::post('/register', [PostController::class, 'store'])->name('store');
    Route::post('/update', [PostController::class, 'update'])->name('update');
    Route::delete('/delete', [PostController::class, 'delete'])->name('delete');
  });
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');