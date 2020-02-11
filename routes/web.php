<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('layout/layout1');
});

Route::resource('classtypes', 'ClassTypeController');

Route::resource('modules', 'ModuleController');
Route::post('modules/search','ModuleController@search')->name('modules.search');


Route::resource('students', 'StudentController');
Route::get('students/search/{pages}/{sortbys}/{sorttypes}/{querys?}', 'StudentController@search')->name('students.search');



// Student
Route::get('/studentss', 'StudentPageController@index')->name('studentss.index');
Route::get('studentss/{id}/edit', 'StudentPageController@edit')->name('studentss.edit');
// Route::get('studentss/fetch_data', 'StudentPageController@fetch_data');
Route::get('studentss/create', 'StudentPageController@create')->name('studentss.create');
Route::post('studentss/create', 'StudentPageController@store')->name('studentss.store');

Route::put('studentss/{id}/update', 'StudentPageController@update')->name('studentss.update');

Route::get('/studentss/fetch_data2', 'StudentPageController@fetch_data2');

Route::get('/studentss/{id}', 'StudentPageController@delete');



Route::get('classes/fetchTeacher', 'ClassesController@fetchTeacher');
Route::get('classes/getClassId', 'ClassesController@getClassId');

Route::resource('classes', 'ClassesController');

Route::resource('teachers', 'TeacherController');

Route::get('chart', 'ChartController@index')->name('chart.index');
Route::get('chart/chart', 'ChartController@chart');
Route::get('chart/average_exam_grades', 'ChartController@average_exam_grades');

Route::resource('status', 'StatusController');

Route::get('evaluate/fetchStuent', 'EvaluateController@fetchStuent');

Route::put('evaluate/edit', 'EvaluateController@update1')->name('update');
Route::resource('evaluate', 'EvaluateController');

Route::put('enrolls/edit', 'EnrollController@updateEnroll')->name('update');
Route::resource('enrolls', 'EnrollController');


