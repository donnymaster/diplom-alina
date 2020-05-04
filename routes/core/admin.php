<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'namespace' => 'Administrator'], function(){
    Route::get('/index', 'AdministratorController@index')->name('admin.index');
    Route::get('/users', 'EmployeeController@users')->name('admin.users');
    Route::get('/facilty/{id}', 'AdministratorController@faculty')->name('admin.faculty');
    Route::post('/edit-departament', 'AdministratorController@departamentEdit')->name('admin.departamentEdit');
    Route::post('/new-departament', 'AdministratorController@departamentNew')->name('admin.departamentNew');

    Route::post('/edit-faculty', 'AdministratorController@facultyEdit')->name('admin.facultyEdit');
    Route::post('/new-faculty', 'AdministratorController@facultyNew')->name('admin.facultyNew');

    Route::post('delete-departament', 'AdministratorController@deleteDepartament')->name('admin.deleteDepartament');
    Route::post('delete-faculty', 'AdministratorController@deleteFaculty')->name('admin.deleteFaculty');

    Route::get('/academiс-degree', 'AdministratorController@degreeShow')->name('admin.degreeShow');
    Route::post('/academiс-degree-edit', 'AdministratorController@degreeEdit')->name('admin.degreeEdit');
    Route::post('/academiс-degree-delete', 'AdministratorController@degreeDelete')->name('admin.degreeDelete');
    Route::post('/academiс-degree-new', 'AdministratorController@degreeNew')->name('admin.degreeNew');

    Route::get('/post', 'AdministratorController@postShow')->name('admin.postShow');
    Route::post('/post-edit', 'AdministratorController@postEdit')->name('admin.postEdit');
    Route::post('/post-delete', 'AdministratorController@postDelete')->name('admin.postDelete');
    Route::post('/post-new', 'AdministratorController@postNew')->name('admin.postNew');

    // обработка типов работы
    Route::get('/type-work', 'AdministratorController@typeWorkShow')->name('admin.typeWorkShow');
    Route::post('/type-work-edit', 'AdministratorController@typeWorkEdit')->name('admin.typeWorkEdit');
    Route::post('/type-work-delete', 'AdministratorController@typeWorkDelete')->name('admin.typeWorkDelete');
    Route::post('/type-work-new', 'AdministratorController@typeWorkNew')->name('admin.typeWorkNew');

    Route::get('/work-group/{id}', 'AdministratorController@workGroupShow')->name('admin.workGroupShow');
    Route::post('/work-group-edit', 'AdministratorController@workGroupEdit')->name('admin.workGroupEdit');
    Route::post('/work-group-delete', 'AdministratorController@workGroupDelete')->name('admin.workGroupDelete');
    Route::post('/work-group-new', 'AdministratorController@workGroupNew')->name('admin.workGroupNew');

    Route::get('/works/{id}', 'AdministratorController@worksShow')->name('admin.worksShow');
    Route::post('/works-edit', 'AdministratorController@worksEdit')->name('admin.worksEdit');
    Route::post('/works-delete', 'AdministratorController@worksDelete')->name('admin.worksDelete');
    Route::post('/works-new', 'AdministratorController@worksNew')->name('admin.worksNew');



    Route::post('/delete-user', 'EmployeeController@deleteUser')->name('admin.del-user');
    Route::post('/update', 'EmployeeController@update')->name('admin.update');
    Route::get('/questions', 'AdministratorController@questions')->name('admin.questions');
    Route::get('/management', 'AdministratorController@management')->name('admin.management');
    Route::get('/account', 'AdministratorController@account')->name('admin.account');

    Route::get('/department/analytics/{id}', 'AdministratorController@departmentAnalytics')->name('admin.departmentAnalytics');
});
