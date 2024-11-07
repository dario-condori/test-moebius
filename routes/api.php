<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware('auth')->group(function () {
    Route::get('/users', [UserControler::class, 'index'])->name('users.index');
    Route::post('/user', [UserControler::class, 'store'])->name('user.store');
    Route::get('/user/{id}', [UserControler::class, 'show'])->name('user.show');
    Route::put('/user/{id}', [UserControler::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [UserControler::class, 'destroy'])->name('user.destroy');
//});
