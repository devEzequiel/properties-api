<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::namespace('Api')->name('user.')->prefix('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])
        ->name('list');
    Route::get('/{id}', [UserController::class, 'show'])
        ->name('show');
    Route::post('/', [UserController::class, 'store'])
        ->name('register');
    Route::put('/{id}', [UserController::class, 'update'])
        ->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])
        ->name('delete');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login');
});

Route::namespace('Api')->middleware('auth:sanctum')->name('property.')->prefix('properties')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])
        ->name('list');
    Route::get('/{id}', [PropertyController::class, 'show'])
        ->name('show');
    Route::post('/', [PropertyController::class, 'store'])
        ->name('create');
    Route::put('/{id}', [PropertyController::class, 'update'])
        ->name('update');
    Route::delete('/{id}', [PropertyController::class, 'destroy'])
        ->name('delete');
});
