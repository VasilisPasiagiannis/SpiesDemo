<?php

use App\Domains\Spies\Http\Controllers\SpyController;

Route::group([
    'prefix' => '/spy',
    'namespace' => 'spy.',
    'as' => 'spy.',
], function () {

    Route::post('/store', [SpyController::class, 'store'])->name('store');
});


Route::group([
    'prefix' => '/spies',
    'namespace' => 'spies.',
    'as' => 'spies.',
], function () {

    Route::get('/get', [SpyController::class, 'get'])->name('get')->middleware('throttle:random-spies');
    Route::get('/all', [SpyController::class, 'listSpies'])->name('paginated');

});


