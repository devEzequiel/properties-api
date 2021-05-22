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

Route::namespace('Api')->prefix('auth')->group(function () {
    Route::post('/signup', [UserController::class, 'store'])
        ->name('user.register');
})
//->middleware('auth:sanctum')
;

Route::namespace('Api')->prefix('properties')->group(function () {
    Route::get('/', [PropertyController::class, 'index'])
        ->name('property.home');
    Route::get('/{id}', [PropertyController::class, 'show'])
        ->name('property.show');
    Route::post('/save', [PropertyController::class, 'store'])
        ->name('property.save');
    Route::put('/{id}/edit', [PropertyController::class, 'update'])
        ->name('property.update');
    Route::delete('/delete/{id}', [PropertyController::class, 'destroy'])
        ->name('property.delete');
});
