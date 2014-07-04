<?php

class ClassesTPsController extends BaseController
{
	public function index($classeId)
	{	
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$tps = $classe->tps; 
		return View::make('classesTPs.index', compact('classe','tps')); 
	}
	
	public function create($classeId)
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		return View::make('classesTPs.create', compact('classe'));
	}
	
	public function edit($classeId, $tpId)
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException, et y a-t-il une facon de demander à la classe de retourner son tp avec cet id?
		return View::make('classesTPs.edit', compact('classe', 'tp'));
	}
	
	
	public function show($classeId, $tpId) 
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$tp = TP::findOrFail($tpId);
		return View::make('classesTPs.show', compact('classe', 'tp'));
	}	
	
	public function store($classeId)
	{
		
		$classe = Classe::findOrFail($classeId); //juste pour s'assurer que l'id de classe passé en paramêtre est valide, sinon: 404. 
		//TODO: catcher ModelNotFoundException
		$input = Input::all();
		
		if (TP::isValid($input)) {
			$tp = new TP;
			$tp->numero = $input['numero'];
			$tp->classe_id = $classeId;
			$tp->nom = $input['nom'];
			$tp->sur = $input['sur'];
			$tp->poids = $input['poids'];
			
			$tp->save();
			
			return Redirect::action('ClassesTPsController@index', $classeId);
		}
	
		return Redirect::back()->withInput()->withErrors(TP::$validationMessages);
				
	}
	
	
	public function update($classeId, $tpId)
	{
		$classe = Classe::findOrFail($classeId); //juste pour s'assurer que l'id de classe passé en paramêtre est valide, sinon: 404.
		//TODO: catcher ModelNotFoundException
		$input = Input::all();
				
		if (TP::isValid($input,$tpId)) { 
			$tp = TP::findOrFail($tpId);
			$tp->numero = $input['numero']; //TODO: si je mets une validation pour que le numero soit unique, je devrais changer mon validateur pour qu'il valide si le numero a changé.
			$tp->nom = $input['nom'];
			$tp->sur = $input['sur'];
			$tp->poids = $input['poids'];
			//Je n'assigne pas la classeId puisqu'on ne peut la changer. 
			$tp->save(); 
		
			return Redirect::action('ClassesTPsController@index', $classeId);
		} else {
			return Redirect::back()->withInput()->withErrors(TP::$validationMessages);
		}
	}
	
	public function destroy($classeId, $tpId)
	{
		$tp = TP::findOrFail($tpId);
		$tp->delete();
		
		return Redirect::action('ClassesTPsController@index', $classeId);		
	}
}