<?php

class ClassesEtudiantsController extends BaseController
{
	public function index($classeId)
	{	
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$etudiants = $classe->etudiants; 
		return View::make('classesEtudiants.index', compact('classe','etudiants')); 
	}
	
	public function create($classeId)
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		return View::make('classesEtudiants.create', compact('classe'));
	}
	
	public function edit($classeId, $etudiantId)
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$etudiant = $classe->etudiants()->where('etudiant_id', '=', $etudiantId)->first();
		return View::make('classesEtudiants.edit', compact('classe', 'etudiant'));
	}
	
	
	public function show($classeId, $etudiantId) 
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$etudiant = $classe->etudiants()->where('etudiant_id', '=', $etudiantId)->first();
		return View::make('classesEtudiants.show', compact('classe', 'etudiant'));
	}	
	
	public function store($classeId)
	{
		$classe = Classe::findOrFail($classeId); //juste pour s'assurer que l'id de classe passé en paramêtre est valide, sinon: 404. 
		//TODO: catcher ModelNotFoundException
		$input = Input::all();
		
		if (Etudiant::isValid($input)) {
			$etudiant = new Etudiant;
			$etudiant->nom = $input['nom'];
			$etudiant->da = $input['da'];			
			$etudiant->save();
			
			//associe la classe au Etudiant (many to many)
			$etudiant->classes()->attach($classeId ); 
			
			return Redirect::action('ClassesEtudiantsController@index', $classeId);
		}
	
		return Redirect::back()->withInput()->withErrors(Etudiant::$validationMessages);
				
	}
	
	
	public function update($classeId, $etudiantId)
	{
		$classe = Classe::findOrFail($classeId); //juste pour s'assurer que l'id de classe passé en paramêtre est valide, sinon: 404.
		//TODO: catcher ModelNotFoundException
		$input = Input::all();
				
		if (Etudiant::isValid($input,$etudiantId)) { 
			$etudiant = $classe->etudiants()->where('etudiant_id', '=', $etudiantId)->first();
			$etudiant->nom = $input['nom'];
			$etudiant->da = $input['da'];
			$etudiant->save(); 
					
			return Redirect::action('ClassesEtudiantsController@index', $classeId);
		} else {
			return Redirect::back()->withInput()->withErrors(Etudiant::$validationMessages);
		}
	}
	
	public function destroy($classeId, $etudiantId)
	{
		$etudiant = Etudiant::findOrFail($etudiantId);
		$etudiant->classes()->detach();
		$etudiant->delete();
		
		// Détruit les notes associées à cette etudiant
		$notes = Note::where('etudiant_id', '=', $etudiantId)->get();
		foreach($notes as $note) {
			$note->delete();
		}
		
		return Redirect::action('ClassesEtudiantsController@index', $classeId);		
	}
	
	
	public function connect($classeId)
	{
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$etudiants = Etudiant::all();
		return View::make('classesEtudiants.connect', compact('classe', 'etudiants'));
	}
	
	public function doConnect($classeId)
	{
		$input= Input::all();
		
		if (isset($input['selectionClasse'])) {
            Classe::find($classeId)->etudiants()->sync($input['selectionClasse']);					
		}
		return Redirect::action('ClassesEtudiantsController@index', $classeId);
		
	}
	
	
	public function disconnect($classeId, $etudiantId)
	{
		// Déconnecte un Etudiant d'une classe sans effacer le Etudiant
		$etudiant = Etudiant::findOrFail($etudiantId);
		$etudiant->classes()->detach($classeId);
		
		// Détruit les notes associées à ce tuple classe/etudiant
		$notes = Note::where('etudiant_id', '=', $classeId)
		->where('classe_id', '=', $etudiantId)->get();
		foreach($notes as $note) {
			$note->delete();
		}
		
		return Redirect::action('ClassesEtudiantsController@index', $classeId);
	}
}