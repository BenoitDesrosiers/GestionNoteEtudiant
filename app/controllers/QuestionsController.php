<?php

/**
 * Le controller pour les questions
 * 
 * @version 0.1
 * @author benou
 *
 */
class QuestionsController extends BaseFilteredResourcesController {

	public function __construct(QuestionsGestion $gestion) {
		//parent::__construct();
		$this->gestion = $gestion;
		$this->base = "questions";
		$this->message_store = "La question a été ajoutée";
		$this->message_update = "La question a été modifiée";
		$this->message_delete = "La question a été effacée";
	}
	
	

	/**
	 * retourne la liste des Questions pour un TP en format JSON
	 *
	 * Doit être appelé par un call AJAX.
	 *
	 * @param[in] post int belongsToId l'id du TP pour lequel on veut lister les Questions. La valeur 0 indique qu'on veut tous les Questions.
	 * @return la sous-view pour afficher les items.
	 *
	 */
	
/*	public function questionsPourTPs() {
		if(Request::ajax()) {
			$belongsToId = Input::get('belongsToId');
			if($belongsToId <> 0) { //Si un TP en particulier est sélectionné, retourne les questions pour celui-ci
				try {
					$belongsTo = TP::findOrFail($belongsToId);
				} catch (Exception $e) {
					return "le TP n'existe pas";
				}
				$questions = $belongsTo->questions;
			} else { //affiche tous les questions pour tous les TPs
				$filtre1Value = Input::get('filtre1Select'); //filtre1 est pour la classe
				if($filtre1Value==0) { //si il n'y a pas de classe de sélectionnée, on prends tous les questions
					$questions = Question::all();
				} else {//une classe est sélectionnée, on affiche donc uniquement les questions des TPs de cette classe 
					$tps = Classe::find($filtre1Value)->tps; 
					$questionsIds = [];
					foreach($tps as $tp) { //créé la liste des ids des questions pour tous ces TPs.
						$questionsIds=array_merge($questionsIds,$tp->questions->lists('id'));
					}
					//une questions peut être avec 2 TPs, il faut donc aller les chercher par leur id afin d'enlever les doublons
					if(count($questionsIds)>0) {
						$questions = Question::whereIn('id', $questionsIds)->get();
					} else {
						$questions = new Illuminate\Database\Eloquent\Collection;
					}
						
				}
			}
			return View::make('questions.listeQuestions_subview')->with('questions',$questions->sortBy("id"))->with('belongsToId',$belongsToId);
	
		} else { //si le call n'est pas ajax.
			return "vous n'avez pas les droits d'obtenir cette information";
		}
	}
*/	
}
