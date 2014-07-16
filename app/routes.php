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

/* Classes TPs */
Route::get('/classes/{classe}/tps/{tps}/disconnectTP', 'ClassesTPsController@disconnect');
Route::get('/classes/{classe}/connectTP', 'ClassesTPsController@connect');
Route::post('/classes/{classe}/doConnectTP', 'ClassesTPsController@doConnect');

/* Classes Etudiants */
Route::get('/classes/{classe}/etudiants/{etudiant}/disconnectEtudiant', 'ClassesEtudiantsController@disconnect');
Route::get('/classes/{classe}/connectEtudiant', 'ClassesEtudiantsController@connect');
Route::post('/classes/{classe}/doConnectEtudiant', 'ClassesEtudiantsController@doConnect');


/* Classes */
Route::resource('classes', 'ClassesController');


/* Travaux pratiques (TP) */
Route::resource('tps', 'TPsController');
Route::resource('classes.tps', 'ClassesTPsController');


Route::get('/tps/{tp}/questions/{questions}/disconnectQuestion', 'TPsQuestionsController@disconnect');
Route::get('/tps/{tp}/connectQuestion', 'TPsQuestionsController@connect');
Route::post('/tps/{tp}/doConnectQuestion', 'TPsQuestionsController@doConnect');

/* Questions */
Route::resource('questions', 'QuestionsController');
Route::resource('tps.questions', 'TPsQuestionsController');

/* Etudiants */
Route::resource('etudiants', 'EtudiantsController');
Route::resource('classes.etudiants', 'ClassesEtudiantsController');

/* Correction / Notes */
Route::get('/classes/{classe}/tps/{tps}/correction', 'TPsNotesController@index');
Route::put('/classes/{classe}/tps/{tps}/correction', 'TPsNotesController@edit');
Route::put('/notes/update', 'TPsNotesController@update');
