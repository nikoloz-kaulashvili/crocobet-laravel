<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TokenController;

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


Route::middleware('auth.token')->group(function () {
    Route::get('/test', function () {
        return response()->json(Auth::guard('token')->user());
    });
});


Route::post('/tokens', [TokenController::class, 'createToken']);
Route::delete('/tokens/{id}', [TokenController::class, 'deleteToken']);


