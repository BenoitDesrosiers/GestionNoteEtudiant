<?php

class EtudiantsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$etudiants = Etudiant::all();
		return View::make('etudiants.index', compact('etudiants'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('etudiants.create');
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		
		if (Etudiant::isValid($input)) {
			$etudiant = new Etudiant;
			$etudiant->nom = $input['nom'];			
			$etudiant->da = $input['da'];
			
			$etudiant->save();
			
			return Redirect::action('EtudiantsController@index');
		}
	
		return Redirect::back()->withInput()->withErrors(Etudiant::$validationMessages);				
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$etudiant = Etudiant::findOrFail($id); //TODO: catcher ModelNotFoundException
		return View::make('etudiants.show', compact( 'etudiant'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$etudiant = Etudiant::findOrFail($id); //TODO: catcher ModelNotFoundException
		return View::make('etudiants.edit', compact( 'etudiant'));	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
				
		if (Etudiant::isValid($input,$id)) { 
			$etudiant = Etudiant::findOrFail($id);
			$etudiant->nom = $input['nom'];
			$etudiant->da = $input['da'];
			$etudiant->save(); 
		
			return Redirect::action('EtudiantsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors(Etudiant::$validationMessages);
		}	
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$etudiant = Etudiant::findOrFail($id);
		$etudiant->classes()->detach();
		$etudiant->delete();
		
		return Redirect::action('EtudiantsController@index');			
	}

}
