<?php
/**
 * Le controller pour les étudiants
 * 
 * 
 * @version 0.1
 * @author benou
 *
 */
class EtudiantsController extends \BaseController {

	/**
	 * Affichage de tous les étudiants.
	 *
	 * @param[in] get int belongsToId l'id de la classe à laquelle les étudiants sont liés. 
	 * 					Une valeur absente ou 0 indique d'afficher tous les étudiants. 
	 * 
	 * @return Response
	 */
	public function index()
	{
		return $this->displayView('etudiants.index','Tous');
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return $this->displayView('etudiants.create','Aucune Classe');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->displayView('etudiants.edit','Aucune Classe',Etudiant::findOrFail($id));
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->displayView('etudiants.show',null,Etudiant::findOrFail($id),true);
	}
	

	private function displayView($view, $option0=null, $item=null, $displayOnlyLinked=null) {
		if(isset($item) and isset($displayOnlyLinked)) {
			$lesClasses = $item->classes;
		} else {
			$lesClasses = Classe::all()->sortby("sessionscholaire_id"); //ce n'est pas exactement par session, mais si les id sont dans le bon ordre, ca le sera.
		}
		$belongsToList = createSelectOptions($lesClasses,[get_class(), 'createOptionsValue'], $option0);
		if(isset($item)) {
			$belongsToSelectedIds =  $item->classes->fetch('id')->toArray();
		} else {
			$belongsToSelectedIds = checkLinkedId(array_keys($belongsToList)[0], Input::get('belongsToId'), 'Classe');
		}
		$filtre1 = createFiltreParSessionPourClasses($lesClasses, true);
		$etudiant = $item; //hack juste pour ne pas avoir a renommer etudiant dans toutes les views. 
		return View::make($view, compact('etudiant', 'belongsToList', 'belongsToSelectedIds','filtre1'));
	}
	
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$classeId = 0;
		//verifie que les ids de classe passé en paramêtre sont bons
		if(isset($input['belongsToListSelect'])) {
			$classeIds = $input['belongsToListSelect'];
			if(!allIdsExist($classeIds, 'Classe')){
				return View::make("erreurSysteme"); 
			}
		} else {
			$classeIds =[]; 
		}		
		$etudiant = new Etudiant;
		$etudiant->nom = $input['nom'];			
		$etudiant->da = $input['da'];
		
		if($etudiant->save()) {
			foreach($classeIds as $classeId) {
				if($classeId <>0 ){
					//associe la classe (many to many)
					$etudiant->classes()->attach($classeId); 
				}
			}
			return Redirect::action('EtudiantsController@index', array('belongsToId'=>$classeId));
		} else {
			return Redirect::back()->withInput()->withErrors($etudiant->validationMessages);
		}				
	}




	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		//verifie que les ids de classe passé en paramêtre sont bons
		$classeIds = Input::get('belongsToListSelect', []);
		if(!allIdsExist($classeIds, 'Classe')){
				return View::make("erreurSysteme"); 
		}		
		$etudiant = Etudiant::findOrFail($id); //TODO catch l'exception
		$etudiant->nom = $input['nom'];
		$etudiant->da = $input['da'];
		if($etudiant->save()) { 
			$etudiant->classes()->sync($classeIds);
			return Redirect::action('EtudiantsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($etudiant->validationMessages);
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
		
		// Détruit les notes associées à ce etudiant
		$notes = Note::where('etudiant_id', '=', $id)->get();
		foreach($notes as $note) {
			$note->delete();
		}
		
		return Redirect::action('EtudiantsController@index');			
	}

	/**
	 * retourne la liste des étudiants pour une classe en format JSON
	 *
	 * Doit être appelé par un call AJAX.
	 *
	 * @param[in] post int classeId l'id de la classe pour lequel on veut lister les étudiants. 
	 * 			La valeur 0 indique qu'on veut tous les étudiants.
	 * @return la sous-view pour afficher les items.
	 *
	 */
	
	public function etudiantsPourClasse() {
		if(Request::ajax()) {
			$belongsToId = Input::get('belongsToId', 0);
			if($belongsToId <> 0) {
				try {
					$belongsTo = Classe::findOrFail($belongsToId);
				} catch (ModelNotFoundException $e) {
					return "la classe n'existe pas";
				}
				$etudiants = $belongsTo->etudiants;
			} else {
				$etudiants = Etudiant::all();
			}
			return View::make('etudiants.listeEtudiants_subview')->with('etudiants',$etudiants)->with('belongsToId',$belongsToId);
	
		} else {
			return "vous n'avez pas les droits d'obtenir cette information";
		}
	}
	
	static function createOptionsValue($item) {
		return $item->sessionscholaire->nom." ". $item->code." ".$item->nom;
	}

}
