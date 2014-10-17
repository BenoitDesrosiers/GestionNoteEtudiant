<?php

/**
 * Le controller pour les classes
 * 
 * @version 0.1
 * @author benou
 *
 */

class ClassesController extends BaseController
{
	public function index()
	{	
		$classes = Classe::all();
		return View::make('classes.index', compact('classes'));
	}
	
	public function create()
	{
		$sessionsList= DB::table("sessionscholaires")->lists( 'nom','id');
		$sessionSelected = DB::table('sessionscholaires')->where("courant", 1)->pluck("id");
		return View::make('classes.create', compact("sessionsList", "sessionSelected"));
	}
	
	public function edit($id)
	{
		$sessionsList= DB::table("sessionscholaires")->lists( 'nom','id');
		$classe = Classe::findOrFail($id);
		$sessionSelected = $classe->sessionscholaire->id;
		return View::make('classes.edit', compact('classe',"sessionsList", "sessionSelected"));
	}
	
	
	public function show($id)
	{
		$classe = Classe::find($id);
		return View::make('classes.show', compact('classe'));
	}	
	
	public function store()
	{
		$input = Input::all();
		$classe = new Classe;
		$classe->code = $input['code'];
		$classe->nom = $input['nom'];
		$classe->groupe = $input['groupe'];
		$classe->local = $input['local'];
		
		$sessionScholaire = Sessionscholaire::findOrFail($input['session']); //TODO catcher l'exception
		if($sessionScholaire->classes()->save($classe)) {
			return Redirect::action('ClassesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($classe->validationMessages);		
		}	
	}
	
	
	public function update($id)
	{
		$input = Input::all();
				
		$classe = Classe::findOrFail($id);
		$classe->code = $input['code'];
		$classe->nom = $input['nom'];
		$classe->groupe = $input['groupe'];
		$classe->local = $input['local'];
		$sessionScholaire = Sessionscholaire::findOrFail($input['session']); //TODO catcher l'exception
		
		if($sessionScholaire->classes()->save($classe)) { 
			return Redirect::action('ClassesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($classe->validationMessages);
		}
	}
	
	public function destroy($id)
	{
		$classe = Classe::findOrFail($id);
		$classe->tps()->detach();
		
		$classe->delete();
		
		// Détruit les notes associées à cette classes
		$notes = Note::where('classe_id', '=', $id)->get();
		foreach($notes as $note) {
			$note->delete();
		}
		return Redirect::action('ClassesController@index');		
	}
}