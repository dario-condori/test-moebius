<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserControler;
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

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/user', [UserControler::class, 'store'])->name('user.store');

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserControler::class, 'index'])->name('users.index');
    Route::get('/user/{id}', [UserControler::class, 'show'])->name('user.show');
    Route::put('/user/{id}', [UserControler::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserControler::class, 'destroy'])->name('user.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
});
