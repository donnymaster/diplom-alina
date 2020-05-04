<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'moderator', 'namespace' => 'Moderator', 'middleware' => 'moderator'], function(){
    Route::get('/index', 'ModeratorController@index')->name('moderator.index');
    Route::get('/employees', 'ModeratorController@employees')->name('moderator.employees');
    Route::post('/employees-edit', 'ModeratorController@employeesEdit')->name('moderator.employeesEdit'); // edit
    Route::post('/employees-delete', 'ModeratorController@employeesDelete')->name('moderator.employeesDelete'); // edit
    Route::get('/request-work', 'ModeratorController@requestWork')->name('moderator.requestWork');
    Route::post('/request-work-add', 'ModeratorController@requestWorkAdd')->name('moderator.requestWorkAdd'); // add work
    Route::post('/request-work-revision', 'ModeratorController@requestWorkRevision')->name('moderator.requestWorkRevision');
    Route::get('/add-user', 'ModeratorController@addUser')->name('moderator.addUser');
    Route::post('/user-add', 'ModeratorController@userAdd')->name('moderator.userAdd');
    Route::post('/no-add-user', 'ModeratorController@noAddUser')->name('moderator.noAddUser');
    Route::get('/users-question', 'ModeratorController@usersQuestion')->name('moderator.usersQuestion');
    Route::post('/users-question-answer', 'ModeratorController@usersQuestionAnswer')->name('moderator.usersQuestionAnswer'); // answer
    Route::get('/works', 'ModeratorController@works')->name('moderator.works');
    Route::get('/work/{id}', 'ModeratorController@work')->name('moderator.work');
    Route::post('/edit-work', 'ModeratorController@editWork')->name('moderator.editWork');
    Route::get('/add-work', 'ModeratorController@addWork')->name('moderator.addWork');
    Route::post('/new-work', 'ModeratorController@newWork')->name('moderator.newWork');
    Route::post('/delete-work', 'ModeratorController@deleteWork')->name('moderator.deleteWork');
    Route::get('/feedback', 'ModeratorController@feedback')->name('moderator.feedback');
    Route::post('/feedback-send', 'ModeratorController@feedbackSend')->name('moderator.feedbackSend');
    Route::get('/account', 'ModeratorController@account')->name('moderator.account');
    Route::get('/my-message', 'ModeratorController@myMessage')->name('moderator.myMessage');
    // new
    Route::post('/change-status', 'ModeratorController@changeStatusWork')->name('moderator.changeStatusWork');

    Route::post('/update-part-work', 'ModeratorController@updateWorkPart')->name('moderator.updateWorkPart');
    //Route::get('/send-mail', 'ModeratorController@sendMail')->name('moderator.sendMail');
});
