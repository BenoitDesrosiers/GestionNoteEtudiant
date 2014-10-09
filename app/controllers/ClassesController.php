<?php

class ClassesController extends BaseController
{
	public function index()
	{	
		$classes = Classe::all();
		return View::make('classes.index', compact('classes'));
	}
	
	public function create()
	{
		return View::make('classes.create');
	}
	
	public function edit($id)
	{
		$classe = Classe::findOrFail($id);
		return View::make('classes.edit', compact('classe'));
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
		$classe->session = $input['session'];
		$classe->groupe = $input['groupe'];
		$classe->local = $input['local'];
			
		if($classe->save()) {			
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
		$classe->session = $input['session'];
		$classe->groupe = $input['groupe'];
		$classe->local = $input['local'];
		
		if($classe->save()) { 
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