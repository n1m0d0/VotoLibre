<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\PartyController;
use App\Http\Controllers\api\v1\RecordController;
use App\Http\Controllers\api\v1\UserController;
use App\Http\Controllers\api\v1\VoteController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('logout', 'logout')->middleware('auth:api')->name('logout');
});

Route::middleware(['auth:api', 'role:supervisor|operator'])
    ->prefix('users')
    ->name('users.')
    ->controller(UserController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        //Route::post('/', 'store')->name('store');
        //Route::put('/{id}', 'update')->name('update');
        //Route::delete('/{id}', 'destroy')->name('destroy');
    });

Route::middleware(['auth:api', 'role:supervisor|operator'])
    ->prefix('parties')
    ->name('parties.')
    ->controller(PartyController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        //Route::get('/{id}', 'show')->name('show');
        //Route::post('/', 'store')->name('store');
        //Route::put('/{id}', 'update')->name('update');
        //Route::delete('/{id}', 'destroy')->name('destroy');
    });

Route::middleware(['auth:api', 'role:supervisor|operator'])
    ->prefix('records')
    ->name('records.')
    ->controller(RecordController::class)
    ->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });

Route::middleware(['auth:api', 'role:supervisor|operator'])
    ->prefix('votes')
    ->name('votes.')
    ->controller(VoteController::class)
    ->group(function () {
        //Route::get('/', 'index')->name('index');
        //Route::get('/{id}', 'show')->name('show');
        //Route::post('/', 'store')->name('store');
        //Route::put('/{id}', 'update')->name('update');
        //Route::delete('/{id}', 'destroy')->name('destroy');
        Route::post('/bulk', 'storeRecordWithVotes')->name('storeRecordWithVotes');
    });
