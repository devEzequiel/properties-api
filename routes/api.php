<?php

use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\SavedPropertyController;
use App\Models\Api\SavedProperty;
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

//routes to manage the users of the app
Route::namespace('Api')->name('user.')->prefix('auth')->group(function () {

    Route::get('/', [UserController::class, 'index'])
        ->name('list');
    Route::get('/{id}', [UserController::class, 'show'])
        ->name('show');
    Route::post('/', [UserController::class, 'store'])
        ->name('register');
    Route::put('/{id}', [UserController::class, 'update'])
        ->name('update')->middleware('auth:sanctum');
    Route::delete('/{id}', [UserController::class, 'destroy'])
        ->name('delete');

    //manage access route
    Route::post('/login', [LoginController::class, 'login'])
        ->name('login');
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout')->middleware('auth:sanctum');

    Route::delete('/logout/{id}', [LoginController::class, 'removeAllTokensFromCurrentUser'])
        ->name('remove_all_tokens')->middleware('auth:sanctum');

});


//routes to acess the proprerties etc (routes protected by sanctum middleware)
Route::namespace('Api')->middleware('auth:sanctum')->name('property.')->prefix('property')->group(function () {

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


//manage and saving properties on the list
Route::namespace('Api')->middleware('auth:sanctum')->name('saved.')->prefix('property')->group(function () {

    Route::post('{id}/save', [SavedPropertyController::class, 'store'])
        ->name('save');

    Route::get('saved', [SavedPropertyController::class, 'show'])
        ->name('show');

    Route::delete('{id}/delete', [SavedPropertyController::class, 'store'])
        ->name('remove');
});