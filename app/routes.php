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
Route::group(['before'=>'auth'], function() {
	/* 
	 * Toutes les routes dans ce groupe demande une authorisation (user login) 
	 */
	Route::get('/','HomeController@index');
	
	/* Classes TPs */
	/*Route::get('/classes/{classe}/tps/{tps}/disconnectTP', 'ClassesTPsController@disconnect');
	Route::get('/classes/{classe}/connectTP', 'ClassesTPsController@connect');
	Route::post('/classes/{classe}/doConnectTP', 'ClassesTPsController@doConnect');
	*/
	/* Classes Etudiants */
	/*Route::get('/classes/{classe}/etudiants/{etudiant}/disconnectEtudiant', 'ClassesEtudiantsController@disconnect');
	Route::get('/classes/{classe}/connectEtudiant', 'ClassesEtudiantsController@connect');
	Route::post('/classes/{classe}/doConnectEtudiant', 'ClassesEtudiantsController@doConnect');
	*/
	
		/* Classes */
		Route::resource('classes', 'ClassesController');
		
		
		/* Travaux pratiques (TP) */
		Route::any('tpsPourClasse', 'TPsController@tpsPourClasse');     //pour l'appel AJAX  
		Route::resource('tps', 'TPsController');
		//Route::resource('classes.tps', 'ClassesTPsController');
		
		/* Questions */
		Route::post('questionsPourTp', 'QuestionsController@questionsPourTp');     //pour l'appel AJAX
		Route::resource('questions', 'QuestionsController');
		//Route::resource('tps.questions', 'TPsQuestionsController');
		
		/* Etudiants */
		Route::post('etudiantsPourClasse', 'EtudiantsController@etudiantsPourClasse');     //pour l'appel AJAX
		Route::resource('etudiants', 'EtudiantsController');
		//Route::resource('classes.etudiants', 'ClassesEtudiantsController');
	
	
	
	/*Route::get('/tps/{tp}/questions/{questions}/disconnectQuestion', 'TPsQuestionsController@disconnect');
	Route::get('/tps/{tp}/connectQuestion', 'TPsQuestionsController@connect');
	Route::post('/tps/{tp}/doConnectQuestion', 'TPsQuestionsController@doConnect');
	*/
	
	
	/* Correction / Notes */
	/*Route::get('/classes/{classe}/tps/{tps}/correction', 'TPsNotesController@index');
	Route::put('/classes/{classe}/tps/{tps}/correction', 'TPsNotesController@edit');
	Route::put('/notes/update', 'TPsNotesController@update');
	*/
});

// Confide routes
Route::get( 'user/create',                 'UserController@create');
Route::post('user',                        'UserController@store');
Route::get( 'user/login',                  'UserController@login');
Route::post('user/login',                  'UserController@do_login');
Route::get( 'user/confirm/{code}',         'UserController@confirm');
Route::get( 'user/forgot_password',        'UserController@forgot_password');
Route::post('user/forgot_password',        'UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}', 'UserController@reset_password');
Route::post('user/reset_password',         'UserController@do_reset_password');
Route::get( 'user/logout',                 'UserController@logout');
