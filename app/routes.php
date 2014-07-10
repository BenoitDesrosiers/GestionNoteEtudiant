<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('/classes/{classe}/tps/{tps}/disconnectTP', 'ClassesTPsController@disconnectTP');
Route::get('/classes/{classe}/connectTP', 'ClassesTPsController@connectTP');
Route::post('/classes/{classe}/doConnectTP', 'ClassesTPsController@doConnectTP');

Route::resource('classes', 'ClassesController');
Route::resource('tps', 'TPsController');

Route::resource('classes.tps', 'ClassesTPsController');


Route::get('/tps/{tp}/questions/{questions}/disconnectQuestion', 'TPsQuestionsController@disconnectQuestion');
Route::get('/tps/{tp}/connectQuestion', 'TPsQuestionsController@connectQuestion');
Route::post('/tps/{tp}/doConnectQuestion', 'TPsQuestionsController@doConnectQuestion');

Route::resource('questions', 'QuestionsController');
Route::resource('tps.questions', 'TPsQuestionsController');