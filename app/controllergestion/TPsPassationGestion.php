<?php 

class TPsPassationGestion extends BaseFilteredGestion{
	
	
public function __construct(TP $model, Classe $filteringClass){
	parent::__construct($model, $filteringClass);
}


/**
 * Affiche la liste des TPs associés à l'étudiant présentement connecté
 * Permet de restreindre les TPs en choissisant une classe.
 *
 */
public function index() {
	return $this->createHeaderForView('Tous',Auth::user());
}

public function show($id){
	return $this->createHeaderForView(null,$this->model->findOrFail($id),true);	
}

private function createHeaderForView( $option0, $item=null, $displayOnlyLinked=null) {
	if(isset($item) and isset($displayOnlyLinked) ) {
		$lesClasses = $item->classes;//affiche seulement les classes associées à cet item.
	} else {//sinon affiche toutes les classes.
		$lesClasses = Classe::all()->sortby("sessionscholaire_id"); //ce n'est pas exactement par session, mais si les id de session sont dans le bon ordre, ca le sera.
	}
	$belongsToList = createSelectOptions($lesClasses,[get_class(), 'createOptionsValue'], $option0);
	if(isset($item)) { //si on a un item, on sélectionne toutes les classes déjà associées
		$belongsToSelectedIds =  $item->classes->fetch('id')->toArray();
	} else { //sinon, on sélectionne la classe qui a été passée en paramêtre (si elle est bonne, sinon, la première de la liste
		$belongsToSelectedIds = checkLinkedId(array_keys($belongsToList)[0], Input::get('belongsToId'), 'Classe'); //TODO je devrai pas avoir d'input ici, ca devrait venir en parametre
	}
	$filtre1 = createFiltreParSessionPourClasses($lesClasses, true);
	$tp = $item;	
	return compact('tp', 'belongsToList', 'belongsToSelectedIds','filtre1');
}

/**
 * retourne les tps associés aux filtres. Groupe les TPs par classes
 *
 * @param[in] filteringItem une classe pour laquelle on veut avoir tous les TPs.
 * @return une collection de TP triée par le nom du TP
 */
protected function filter1( $filteringItem) {
	//$filteringItems doit être une Classe
	$lignes = [];
	$lignes[$filteringItem->nom] = $filteringItem->tps->sortBy('nom');
	return $lignes;
}
protected function filter2($filterValue) {
	//Pour appeler cette function, filter1 doit être sur TOUS
	//Pour les TPs, le filter 2 est la sessionScholair
	try {
		if($filterValue == 0) {// 0 indique 'Tous' sur filter2
			$classes = Auth::user()->classes->sortBy("sessionscholaire_id");
		} else {
			$classes = $this->filteringClass->where('sessionscholaire_id', '=' , $filterValue)->get(); //va chercher les classes pour cette session
		}
		$lignes = [];
		foreach($classes as $classe) {
			$lignes[$classe->nom] = $classe->tps->sortBy('nom');
		}
	} catch (Exception $e) {
		$lignes = [];
	}

	return $lignes;
}




/**
 * Helpers
 *
 */
static function createOptionsValue($item) {
	return $item->sessionscholaire->nom." ". $item->code." ".$item->nom;
}

}