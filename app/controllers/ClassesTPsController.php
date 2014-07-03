<?php

class ClassesTPsController extends BaseController
{
	public function index($classesId)
	{	
		$classe = Classe::find($classesId);
		$tps = $classe->tps; 
		return View::make('classesTPs.index', compact('classe','tps')); 
	}
	
	public function create()
	{
		return View::make('classesTPs.create');
	}
	
	public function edit($id)
	{
		$classe = Classe::findOrFail($id);
		return View::make('classesTPs.edit', compact('classe'));
	}
	
	
	public function show($id)
	{
		$classe = Classe::find($id);
		return View::make('classesTPs.show', compact('classe'));
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
			
			return Redirect::action('ClassesTPsController@index');
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
		
			return Redirect::action('ClassesTPsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors(Classe::$validationMessages);
		}
	}
	
	public function destroy($id)
	{
		$classe = Classe::findOrFail($id);
		$classe->delete();
		
		return Redirect::action('ClassesTPsController@index');		
	}
}