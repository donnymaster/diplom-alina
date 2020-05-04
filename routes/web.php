<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/**
 * index
 */
Route::get('/', function () {
    return redirect()->route('login');
});

/**
 * Auth pages
 */
Auth::routes();

Route::get('/register', function () {
    return redirect()->route('login');
});

Route::post('/register', 'User\UserController@store');
Route::get('/new-user', 'User\UserController@newUser')->name('new.user');

/**
 * File routes
 */
Route::group(['middleware' => 'auth', 'namespace' => 'File'], function () {
    Route::get('app/uploads/{id}/feedback/{hash}/{filename}', 'FeedbackFileController@getFile');
});

Route::group(['middleware' => 'auth', 'namespace' => 'File'], function () {
    Route::get('app/uploads/{id}/works/{hash}/{filename}', 'WorkFileController@getFile');
});
