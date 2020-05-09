<?php

use Illuminate\Support\Facades\Route; 


Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
    Route::get('/index', 'UserController@index')->name('user.index');

    Route::get('/account', 'UserController@account')->name('user.account');

    Route::get('/my-work', 'UserController@myWorks')->name('user.works');
    Route::get('/add-work', 'PlanWorkController@create')->name('user.addWork');
    Route::post('/delete-account', '@sendMessageDeleteAccount')->name('user.delete-account');

    Route::get('/feedback', 'FeedbackController@create')->name('user.feedback');
    Route::post('/send-message', 'FeedbackController@store')->name('user.sendMessageUser');

    Route::get('/my-message', 'MessageController@index')->name('user.message');
    Route::get('/change-message/{id}', 'MessageController@changeStatusMessage');
    Route::post('/delete-message/{id}', 'MessageController@deleteMessage')->name('user.delete-message');
    Route::post('/deleteAllMessage', 'MessageController@deleteAllMessage')->name('user.deleteAllMessage');

    Route::post('/reset-email', 'UserController@resetEmail')->name('user.resetEmail');
    Route::post('/reset-password', 'UserController@resetPassword')->name('user.resetPass');

    Route::post('/create-work', 'PlanWorkController@store')->name('user.CreateWork');
    Route::post('/edit-work', 'UserController@EditWork')->name('user.EditWork');
});
