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

	
		/* Classes */
		Route::resource('classes', 'ClassesController');
		
		
		/* Travaux pratiques (TP) */
		Route::get('tpsDistribuer/{id}', ['as' => 'tps.distribuer', 'uses' => 'TPsController@distribuer']);
		Route::post('tpsDistribuer/{id}',  ['as' => 'tps.doDistribuer', 'uses' => 'TPsController@doDistribuer']);
		Route::get('tpsCorriger/{tpid}/{classeid}',  ['as' => 'tps.corriger', 'uses' => 'TPsController@corriger']);
		Route::put('tpsDoCorriger',  ['as' => 'tps.doCorriger', 'uses' => 'TPsController@doCorriger']);
		Route::any('afficheReponseAutreEtudiant', ['as' => 'tps.afficheReponseAutreEtudiant', 'uses' => 'TPsController@afficheReponseAutreEtudiant']); //call Ajax
		Route::get('tpsTransmettreCorrection/{tpid}/{classeid}', ['as' => 'tps.transmettreCorrection', 'uses' => 'TPsController@transmettreCorrection']);
		Route::get('tpsRetirerCorrection/{tpid}/{classeid}', ['as' => 'tps.retirerCorrection', 'uses' => 'TPsController@retirerCorrection']);
		Route::get('tpsFormat/{id}', ['as' => 'tps.format', 'uses' => 'TPsController@format']);
		Route::put('tpsDoFormat/{id}', ['as' => 'tps.doFormat', 'uses' => 'TPsController@doFormat']);
		
		Route::any('tpsPourClasse', ['as' => 'tpsPourClasse', 'uses' => 'TPsController@itemsFor2Filters']);     //pour l'appel AJAX  
		Route::resource('tps', 'TPsController');
		
		/* Passation des TPs */ 
		Route::post('tpsPassationPourClasse', ['as' => 'tpsPassationPourClasse', 'uses' => 'TPsPassationController@itemsFor2Filters']);     //pour l'appel AJAX
		Route::get('tpsPassationIndex', ['as' => 'tpsPassation.index', 'uses' => 'TPsPassationController@index']);
		Route::get('tpsPassationRepondre/{classeId}/{tpId}', ['as' => 'tpsPassation.repondre', 'uses' => 'TPsPassationController@repondre']);
		Route::put('tpsPassationDoRepondre', ['as' => 'tpsPassation.doRepondre', 'uses' => 'TPsPassationController@doRepondre']);
		Route::get('tpsPassationVoirCorrection/{classeId}/{tpId}', ['as' => 'tpsPassation.voirCorrection', 'uses' => 'TPsPassationController@voirCorrection']);
		Route::put('tpsPassationVoirSuiteCorrection',  ['as' => 'tpsPassation.voirSuiteCorrection', 'uses' => 'TPsPassationController@voirSuiteCorrection']);
		
		/* Questions */
		Route::post('questionsPourTp', ['as' => 'questionsPourTp', 'uses' => 'QuestionsController@itemsFor2Filters' ]);     //pour l'appel AJAX
		Route::resource('questions', 'QuestionsController');
		
		/* Etudiants */
		Route::post('etudiantsPourClasse', ['as' => 'etudiantsPourClasse', 'uses' => 'EtudiantsController@itemsFor2Filters']);     //pour l'appel AJAX
		Route::resource('etudiants', 'EtudiantsController');
	
		
		// la création d'un usager ne peu se faire que par un usager déjà connecté. 
		// TODO: ajouter que seul les gestionnaires peuvent le faire. Mais j'ai besoin de Entrust pour ca
		Route::get( 'users/create',                 'UsersController@create');
		
});

// Confide routes
Route::post('users',                        'UsersController@store');
Route::get( 'users/login',                  'UsersController@login');
Route::post('users/login',                  'UsersController@do_login');
Route::get( 'users/confirm/{code}',         'UsersController@confirm');
Route::get( 'users/forgot_password',        'UsersController@forgot_password');
Route::post('users/forgot_password',        'UsersController@do_forgot_password');
Route::get( 'users/reset_password/{token}', 'UsersController@reset_password');
Route::post('users/reset_password',         'UsersController@do_reset_password');
Route::get( 'users/logout',                 'UsersController@logout');

// Dashboard route
Route::get('userpanel/dashboard', function(){ return View::make('userpanel.dashboard'); });

// Applies auth filter to the routes within admin/
Route::when('userpanel/*', 'auth');
//

// Confide routes
Route::get('users/create', 'UsersController@create');
Route::post('users', 'UsersController@store');
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('users/logout', 'UsersController@logout');
