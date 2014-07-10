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
		$tp = $classe->tps()->where('tp_id', '=', $tpId)->first();
		return View::make('classesTPs.edit', compact('classe', 'tp'));
	}
	
	
	public function show($classeId, $tpId) 
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$tp = $classe->tps()->where('tp_id', '=', $tpId)->first();
		return View::make('classesTPs.show', compact('classe', 'tp'));
	}	
	
	public function store($classeId)
	{
		
		$classe = Classe::findOrFail($classeId); //juste pour s'assurer que l'id de classe passé en paramêtre est valide, sinon: 404. 
		//TODO: catcher ModelNotFoundException
		$input = Input::all();
		
		if (TP::isValid($input)) {
			$tp = new TP;
			$tp->nom = $input['nom'];
			$tp->sur = $input['sur'];
			$tp->poids = $input['poids'];
			
			$tp->save();
			
			//associe la classe au TP (many to many)
			$tp->classes()->attach($classeId, ['poids_local'=>$tp->poids]); // pour la création, je prends le poids du tp pour le poids local
			
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
			$tp = $classe->tps()->where('tp_id', '=', $tpId)->first();
			$tp->nom = $input['nom'];
			$tp->sur = $input['sur'];
			$tp->poids = $input['poids'];
			$tp->save(); 
			
			$tp->pivot->poids_local = $input['poids_local'];
			$tp->pivot->save();
		
			return Redirect::action('ClassesTPsController@index', $classeId);
		} else {
			return Redirect::back()->withInput()->withErrors(TP::$validationMessages);
		}
	}
	
	public function destroy($classeId, $tpId)
	{
		$tp = TP::findOrFail($tpId);
		$tp->classes()->detach();
		$tp->delete();
		
		return Redirect::action('ClassesTPsController@index', $classeId);		
	}
	
	
	public function connectTP($classeId)
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$tps = TP::all();
		return View::make('classesTPs.connectTP', compact('classe', 'tps'));
	}
	
	public function doConnectTP($classeId)
	{
		$input= Input::all();
		
		if (isset($input['selectionClasse'])) {
			$lesClasses = implode(',', $input['selectionClasse']);
			//TODO: pour l'instant, le poid local est à 0, faudrait passer le poids local si il existe déjà, ou le poid du tp sinon... un peu complex.
			$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
					
		}
		return Redirect::action('ClassesTPsController@index', $classeId);
		
	}
	
	
	public function disconnectTP($classeId, $tpId)
	{
		// Déconnecte un TP d'une classe sans effacer le TP
		$tp = TP::findOrFail($tpId);
		$tp->classes()->detach($classeId);
		
		return Redirect::action('ClassesTPsController@index', $classeId);
	}
}