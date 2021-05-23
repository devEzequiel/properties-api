<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\PropertyController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {

});

Route::namespace('Api')->name('user.')->prefix('auth')->group(function () {
    Route::get('/{id}', [UserController::class, 'show'])
        ->name('show');
    Route::post('/', [UserController::class, 'store'])
        ->name('register');
    Route::put('/{id}', [UserController::class, 'update'])
        ->name('update');
})
//->middleware('auth:sanctum')
;

Route::namespace('Api')->name('property.')->prefix('properties')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])
        ->name('list');
    Route::get('/{id}', [PropertyController::class, 'show'])
        ->name('show');
    Route::post('/save', [PropertyController::class, 'store'])
        ->name('create');
    Route::put('/{id}/edit', [PropertyController::class, 'update'])
        ->name('update');
    Route::delete('/delete/{id}', [PropertyController::class, 'destroy'])
        ->name('delete');
});
