<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserTokenController;

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


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/tokens', [UserTokenController::class, 'create'])->name('tokens.create');
    Route::delete('/tokens/{token}', [UserTokenController::class, 'delete'])->name('tokens.delete');
});




// Route::post('/tokens', [TokenController::class, 'createToken']);
// Route::delete('/tokens/{id}', [TokenController::class, 'deleteToken']);

