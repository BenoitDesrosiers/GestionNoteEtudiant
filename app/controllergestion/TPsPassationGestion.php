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
		return $this->createFilters('Tous',Auth::user());
}

public function show($id){
	return $this->createFilters(null,$this->model->findOrFail($id),true);	
}

public function repondre($etudiant_id, $classe_id, $tp_id, $pageCourante) {
	
 	$etudiant = User::findorfail($etudiant_id); //TODO catch exception (au pire, retourner une liste vide)
	$classe = Classe::findorfail($classe_id);
	$tp = $classe->tps()->where('tp_id',"=", $tp_id)->first();
	//store les ids afin de pouvoir les récupérer au retour afin que l'étudiant ne puisse répondre à d'autre questions.
	Session::put('etudiantId', $etudiant_id);
	Session::put('classeId', $classe_id);
	Session::put('tpId', $tp_id);
	$lesQuestions = $tp->questions()->orderBy('ordre')->get();
	//batit la pagination des questions
	$i = 1;
	foreach($lesQuestions as $question) {
		$page[$i][] = $question->id;
		if($question->pivot->breakafter == 1) { $i++; } 	
	}
	//batit la liste des réponses déjà soumise par l'étudiant associé aux questions de la page affichée
	$lesReponses = Note::where('classe_id','=',$classe_id)
					->where('tp_id','=',$tp_id)
					->where('etudiant_id','=',$etudiant_id)
					->whereIn('question_id',$page[$pageCourante])
					->get();
	
	
	foreach($lesReponses as $uneReponse) {
		$reponses[$uneReponse->question_id] = $uneReponse->reponse;
	}
	if(!empty($page[$pageCourante+1])) {
		$pageSuivante = $pageCourante+1;
	} else {
		$pageSuivante = null;
	}
	if(!empty($page[$pageCourante-1])) {
		$pagePrecedente = $pageCourante-1;
	} else {
		$pagePrecedente = null;
	}
	$questions = $lesQuestions->filter(function($item) use ($page, $pageCourante) { return in_array($item->id,$page[$pageCourante]);} );
	return  compact('questions','reponses','tp','classe_id','etudiant_id', 'pagePrecedente', 'pageCourante','pageSuivante');
}

public function doRepondre($etudiant_id, $classe_id, $tp_id,$input) {
	
	if(isset($input['sauvegarde'])) {
		$return = "sauvegarder";  //le bouton Sauvegarder a été utilisé, on retourne sur le formulaire
	} elseif(isset($input['suivant'])){
		$return = 'suivant';
	} elseif(isset($input['precedent'])) {
		$return = 'precedent';
	} else {
		$return = "terminer"; //le bouton terminé a été utilisé, on sauve et on quitte. 
	}
	$pageCourante = $input['pageCourante'];
	$etudiant_id = Session::get('etudiantId');
	$classe_id = Session::get('classeId');
	$tp_id = Session::get('tpId');
	
	$etudiant = User::findorfail($etudiant_id); // pas besoin de les vérifier puisque ca provient de la session ... à moins qu'il ait été effacé entretemps
	$classe = Classe::findorfail($classe_id);
	$tp = TP::findorfail($tp_id);
	$lesQuestions = $tp->questions()->orderBy('ordre')->get();
	//batit la pagination des questions
	$i = 1;
	foreach($lesQuestions as $question) {
		$page[$i][] = $question->id;
		if($question->pivot->breakafter == 1) { $i++; }
	}
	//choisi la bonne page de questions
	$questions = $lesQuestions->filter(function($item) use ($page, $pageCourante) { return in_array($item->id,$page[$pageCourante]);} );
	
	
	//verifie que c'est les bonnes questions qui nous revienne
	$listeIdReponses = 	array_keys($input['reponse']);
	foreach($questions as $question) {
		if(!in_array($question->id, $listeIdReponses)) {
			$return='erreur'; 
		}
	}
	
	if($return <> 'erreur') { // on a toutes les réponses, on peut les stocker
		foreach($questions as $question) {
			$note = Note::where('classe_id','=',$classe_id)
					->where('tp_id','=',$tp_id)
					->where('etudiant_id','=',$etudiant_id)
					->where('question_id','=',$question->id)->first(); // cette requete devrait toujour fonctionner
			$note->reponse = $input['reponse'][$question->id];
			$note->save();
		}
	}
	return $return;
}
private function createFilters( $option0, $item=null, $displayOnlyLinked=null) {
	if(isset($item) and isset($displayOnlyLinked) ) {
		$lesClasses = $item->classes->sortby("sessionscholaire_id");//affiche seulement les classes associées à cet item.
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
 * Call back
 *
 */
static function createOptionsValue($item) {
	return $item->sessionscholaire->nom." ". $item->code." ".$item->nom;
}

}