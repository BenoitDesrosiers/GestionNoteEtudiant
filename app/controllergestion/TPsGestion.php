<?php 

class TPsGestion extends BaseFilteredGestion{

	/*******
	******
	***** TODO: associer un TP à un prof
	*****
	***/
	
	
public function __construct(TP $model, Classe $filteringClass){
	parent::__construct($model, $filteringClass);
}

protected function filter1( $filteringItem) {
	//$filteringItems doit être une Classe
	$lignes = [];
	$lignes[$filteringItem->nom] = $filteringItem->tps->sortBy('nom');
	return $lignes; 
}
protected function filter2($filterValue) {
	//Pour les TPs, le filter 2 est la sessionScholaire
		try {
			if($filterValue == 0) {// 0 indique 'Tous' sur filter2
				$classes = Classe::all();
			} else {
				$classes = $this->filteringClass->where('sessionscholaire_id', '=' , $filterValue)->get(); //va chercher les classes pour cette session
			}
			$lignes = [];
			foreach($classes as $classe) { //créé la liste des ids des TPs pour toutes ces classes.
				$lignes[$classe->nom] = $classe->tps->sortBy('nom');
			}	
			
			// liste les TPs qui ne sont associés à aucune classe. 
			$tps = TP::all();
			foreach($tps as $tp){
				if($tp->classes->isempty()) {$listeTPsOrphelins[]=$tp->id;}
			}
			if(!empty($listeTPsOrphelins)) {
				$lignes['Aucune classe associée'] = TP::wherein('id',$listeTPsOrphelins)->get();
			}
		} catch (Exception $e) {
			$lignes = [];
		}	
	return $lignes;
}

public function index() {
	return $this->createHeaderForView( 'Tous');
	
}
public function create() {
	return $this->createHeaderForView('Aucune Classe');
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
	return $this->createHeaderForView(null,$this->model->findOrFail($id),true);
	
}

public function edit($id){
	return $this->createHeaderForView('Aucune classe', $this->model->findOrFail($id));
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

private function createHeaderForView( $option0, $item=null, $displayOnlyLinked=null) {
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
 * Affiche la liste des classes associées à ce TP afin de permettre de choisir lesquels distribuer
 * 
 * @param integer $id l'id du TP à distribuer
 * @return view la view pour choisir pour quelles classes distribuer le TP
 */
public function distribuer($id) {
	$lignes= [];
	try {
		$tp = $this->model->findOrFail($id);
		$classes = $tp->classes;
		foreach($classes as $classe) {
			$dejaDistribue = !(Note::forClasse($classe->id)->forTP($tp->id)->get()->isEmpty());
			$lignes[$classe->id] = ['classeid' => $classe->id, 'nom' => $classe->nom, 'session' => $classe->sessionscholaire->nom,'dejaDistribue'=>$dejaDistribue ];
		}
	} catch (Exception $e) {
		$tp = new $this->model;
	}
	
	
	return compact('tp', 'lignes');
}

public function doDistribuer($id, $input){
	$return = true;
	try {
		$tp = $this->model->findOrFail($id);
		$classes = $tp->classes;
		
		foreach($classes as $classe) { //TODO mettre toute la création dans une transaction
			if(isset($input['distribue'])) {
				if(in_array($classe->id,$input['distribue'])) { //le checkbox distribuer pour cette classe est sélectionné
					Note::forClasse($classe->id)->forTP($tp->id)->delete(); //efface les notes déjà distribuées pour ce TP/Classe
					$etudiants= $classe->etudiants;
					$questions = $tp->questions;
					foreach($etudiants as $etudiant) {
						foreach($questions as $question) {
							$note = new Note;
							$note->classe_id = $classe->id;
							$note->tp_id = $tp->id;
							$note->question_id = $question->id;
							$note->etudiant_id = $etudiant->id;
							$note->save();
						}
					}
					//distribue une copie au prof pour qu'il puisse l'essayer
					foreach($questions as $question) {
						$note = new Note;
						$note->classe_id = $classe->id;
						$note->tp_id = $tp->id;
						$note->question_id = $question->id;
						$note->etudiant_id = Auth::user()->id;
						$note->save();
					}
				}
			}
			if(isset($input['retire'])){
				if(in_array($classe->id,$input['retire'])) { //le checkbox retirer pour cette classe est sélectionné
					Note::forClasse($classe->id)->forTP($tp->id)->delete(); //efface les notes déjà distribuées pour ce TP/Classe
				}
			}
		}
	} catch (Exception $e) {
		$return = false;
	}
	
	return $return;
}

/**
 * Formattage des questions sur le TP
 */


public function format($id) {
	$tp = TP::findOrFail($id);
	$questions = $tp->questions()->orderBy('ordre')->get();
	return(compact('tp','questions'));
}

public function doFormat($id, $input) {
	$tp = TP::findOrFail($id);
	$ordres= $input['ordre'];
	$breaks= $input['break'];
	$questions = $tp->questions();
	foreach($ordres as $id => $ordre) {
		$questions->updateExistingPivot($id, ['ordre' => $ordre], false);
	} 
	foreach($breaks as $id => $value) {
		$questions->updateExistingPivot($id, ['breakafter' => 1], false);
	}
	
	return true;
}


/**
 * Correction d'un TP
 */


/**
 * Retourne l'information nécessaire pour faire la correction d'une question d'un TP d'une classe pour un étudiant
 * 
 * @param integer $tp_id
 * @param integer $classe_id
 * @param integer $offset_etudiant le numéro de séquence de l'étudiant à corriger 
 * @param integer $offset_question le numéro de séquence de la question à corriger 
 */
public function corriger($tp_id, $classe_id, $offset_etudiant, $offset_question) {
	try{
		$classe= Classe::findOrFail($classe_id);
		$tp = $classe->tps()->where("tp_id",'=',$tp_id)->first();
	} catch (Exception $e) {
		throw new Exception("Paramêtres incorrects");
	}
	$questions = $tp->questions()->orderBy('ordre')->get();
	$etudiants = $classe->etudiants()->orderBy('id')->get();
	//batit la liste des réponses déjà soumise par l'étudiant associé aux questions de la page affichée
	$offset_etudiant = max(0,min($offset_etudiant,$etudiants->count()));
	$offset_question = max(0,min($offset_question,$questions->count()));
	$etudiant = $etudiants->offsetGet($offset_etudiant);
	$question = $questions->offsetGet($offset_question);
	$reponse = Note::where('classe_id','=',$classe->id)
					->where('tp_id','=',$tp->id)
					->where('etudiant_id','=',$etudiant->id)
					->where('question_id',$question->id)
					->first();
	
	$flagEtudiantSuivant = ($offset_etudiant == $etudiants->count())?false:true;
	$flagQuestionSuivante = ($offset_question == $questions->count())?false:true;
	$flagEtudiantPrecedent = ($offset_etudiant == 0);
	$flagQuestionPrecedente = ($offset_question == 0);
	//Sauvegarde les ids de la réponse que l'on traite afin d'être certain que les infos n'auront pas été trafiqués au retour
	Session::put('etudiantId', $etudiant->id);
	Session::put('classeId', $classe_id);
	Session::put('tpId', $tp_id);
	Session::put('questionId', $question->id);
	Session::put('offsetEtudiant', $offset_etudiant);
	Session::put('offsetQuestion', $offset_question);
	return compact('tp', 'classe', 'etudiant','question','reponse', 'flagEtudiantPrecedent', 'flagEtudiantSuivant', 'flagQuestionPrecedente', 'flagQuestionSuivante');
}

/**
 * Sauvegarde la correction 
 * @param unknown $etudiant_id
 * @param unknown $classe_id
 * @param unknown $tp_id
 * @param unknown $questions_id
 * @param unknown $input
 */
public function doCorriger($etudiant_id, $classe_id, $tp_id, $questions_id, $input) {
	dd('iccite');
	
	
}
/**
 * Helpers
 *
 */
static function createOptionsValue($item) {
	return $item->sessionscholaire->nom." ". $item->code." ".$item->nom;
}

}