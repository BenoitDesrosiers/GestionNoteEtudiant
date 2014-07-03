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
		
		if (Classe::isValid($input)) { //parce que j'ai pas le champ $id dans isValid, le champ 'code' devra être unique dans la BD
			$classe = new Classe;
			$classe->code = $input['code'];
			$classe->nom = $input['nom'];
			$classe->session = $input['session'];
			$classe->groupe = $input['groupe'];
			$classe->local = $input['local'];
			
			$classe->save();
			
			return Redirect::action('ClassesController@index');
			//ou Redirect::to('classes');
		}
		
		return Redirect::back()->withInput()->withErrors(Classe::$validationMessages);
				
	}
	
	
	public function update($id)
	{
		$input = Input::all();
				
		if (Classe::isValid($input,$id)) { // parce que j'ai passé $id, la validation va exclure cet id pour la clause unique du champs 'code'
			$classe = Classe::findOrFail($id);
			$classe->code = $input['code'];
			$classe->nom = $input['nom'];
			$classe->session = $input['session'];
			$classe->groupe = $input['groupe'];
			$classe->local = $input['local'];
		
			$classe->save(); 
		
			return Redirect::action('ClassesController@index');
		} else {
			return Redirect::back()->withInput()->withErrors(Classe::$validationMessages);
		}
	}
	
	public function destroy($id)
	{
		$classe = Classe::findOrFail($id);
		$classe->delete();
		
		return Redirect::action('ClassesController@index');		
	}
}