<?php

use App\Domains\Auth\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::post('login', [UserController::class,'login'])->name('api.login');

Route::group(['namespace' => 'Api', 'prefix' => '/', 'as' => 'api.', 'middleware' => 'auth:api'], function () {
    Route::post('logout', [UserController::class,'logout'])->name('logout');
});


Route::group(['namespace' => 'Api', 'prefix' => '/', 'as' => 'api.external.', 'middleware' => 'auth:api'], function () {
    includeRouteFiles(__DIR__.'/api/external');
});
