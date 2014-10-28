<?php 

class TPsGestion extends BaseFilteredGestion{

public function __construct(TP $model, Classe $filteringClass){
	parent::__construct($model, $filteringClass);
}

protected function filter1( $filteringItem) {
	//$filteringItems doit être une Classe
	return $filteringItem->tps->sortBy('nom'); 
}
protected function filter2($filterValue) {
	//Pour les TPs, le filter 2 est la sessionScholaire
	if($filterValue == 0) {// 0 indique 'Tous' sur filter2 
		$lignes = $this->model->all()->sortBy('nom');
	} else {
		try {
			$filterByItems = $this->filteringClass->where('sessionscholaire_id', '=' , $filterValue)->get(); //va chercher les classes pour cette session
			$modelIds = [];
			foreach($filterByItems as $item) { //créé la liste des ids des TPs pour toutes ces classes.
				$modelIds=array_merge($modelIds,$this->filter1($item)->lists('id'));
			}
			
			//un TP peut être avec 2 classes, il faut donc aller les chercher par leur id afin d'enlever les doublons
			if(count($modelIds)>0) {
				$lignes = $this->model->whereIn('id', $modelIds)->get()->sortBy('nom');
			} else { //aucun TP de retourné, on créé donc une liste vide. 
				$lignes = new Illuminate\Database\Eloquent\Collection;
			}
		} catch (Exception $e) {
			$lignes = new Illuminate\Database\Eloquent\Collection;
		}
	}
	return $lignes;
}

public function index() {
	return $this->displayView( 'Tous');
	
}
public function create() {
	return $this->displayView('Aucune Classe');
}


/**
 * Enregistrement initial dans la BD
 *
 *
 * @param[in] get int belongsToListSelect les ids des classes auxquelles ce TP sera associé.
 * 					Si vide, alors le tp ne sera associé à rien.
 * 				 	Les ids doivent être valide, sinon une page d'erreur sera affichée.
 *
 */
public function store($input) {
	$classeId = 0;
	//verifie que les ids de classe passé en paramêtre sont bons
	if(isset($input['belongsToListSelect'])) {
			$classeIds = $input['belongsToListSelect'];
			if(!allIdsExist($classeIds, 'Classe')){
				App::abort(404); 
			}
	} else {
			$classeIds =[]; 
	}
	$tp = new $this->model(['nom'=>$input['nom'], 'poids'=>$input['poids']]);
	if($tp->save()) {//TODO: mettre ca dans une transaction
		foreach($classeIds as $classeId) {
			if($classeId <>0 ){
				//associe la classe au TP (many to many)
				$tp->classes()->attach($classeId, ['poids_local'=>$tp->poids]); // pour la création, je prends le poids du tp pour le poids local
			}
		}
		return true;
	} else {
		return $tp->validationMessages;
	}

}

public function show($id){
	return $this->displayView(null,$this->model->findOrFail($id),true);
	
}

public function edit($id){
	return $this->displayView('Aucune classe', $this->model->findOrFail($id));
}

public function update($id, $input){
		//verifie que les ids de classe passé en paramêtre sont bons
		if(isset($input['belongsToListSelect'])) {
				$classeIds = $input['belongsToListSelect'];
				if(!allIdsExist($classeIds, 'Classe')){
					App::abort(404); 
				}
		} else {
				$classeIds =[]; 
		}
					
		$tp = $this->model->findOrFail($id); //TODO catch l'exception
		$tp->nom = $input['nom'];
		$tp->poids = $input['poids'];
		if($tp->save()) {
			$tp->classes()->sync($classeIds);
			return true;
		} else {
			return $tp->validationMessages;
			}

}

public function destroy($id){
	$tp = $this->model->findOrFail($id);
	$tp->classes()->detach();
	$tp->delete();
	// Détruit les notes associées à ce tp
	$notes = Note::where('tp_id', '=', $id)->get();
	foreach($notes as $note) {
		$note->delete();
	}
	
	return true;
}

private function displayView( $option0, $item=null, $displayOnlyLinked=null) {
	if(isset($item) and isset($displayOnlyLinked) ) {
		$lesClasses = $item->classes;//affiche seulement les classes associées à cet item. (utile pour show)
	} else {//sinon affiche toutes les classes.
		$lesClasses = Classe::all()->sortby("sessionscholaire_id"); //ce n'est pas exactement par session, mais si les id sont dans le bon ordre, ca le sera.
	}
	$belongsToList = createSelectOptions($lesClasses,[get_class(), 'createOptionsValue'], $option0);
	if(isset($item)) { //si on a un item, on sélectionne toutes les classes déjà associées
		$belongsToSelectedIds =  $item->classes->fetch('id')->toArray();
	} else { //sinon, on sélectionne la classe qui a été passée en paramêtre (si elle est bonne, sinon, la première de la liste
		$belongsToSelectedIds = checkLinkedId(array_keys($belongsToList)[0], Input::get('belongsToId'), 'Classe');
	}
	$filtre1 = createFiltreParSessionPourClasses($lesClasses, true);
	$tp = $item;	
	return compact('tp', 'belongsToList', 'belongsToSelectedIds','filtre1');
}
/**
 * Helpers
 *
 */
static function createOptionsValue($item) {
	return $item->sessionscholaire->nom." ". $item->code." ".$item->nom;
}

}