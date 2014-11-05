<?php
use Illuminate\Support\Facades;
/**
 * Le controller pour la passsation des travaux pratiques
 *
 *
 * @version 0.1
 * @author benou
 */

class TPsPassationController extends BaseFilteredResourcesController
{
	
	public function __construct(TPsPassationGestion $gestion) {
		//parent::__construct();
		$this->gestion = $gestion;
		$this->base = "tpsPassation";
		
	}

	/**
	 * affiche la view pour répondre à un questionnaire
	 * @param integer $etudiant_id
	 * @param integer $classe_id
	 * @param integer $tp_id
	 * @return la view pour répondre     
	 */
	//TODO: faire une réponse paginée
	
	public function repondre($etudiant_id, $classe_id, $tp_id) {
		//vérifie que les id sont bons. 
		return View::make($this->base.'.repondre', $this->gestion->repondre($etudiant_id, $classe_id, $tp_id, 1) );
	}
 	
	public function doRepondre($etudiant_id, $classe_id, $tp_id) {
		$return = $this->gestion->doRepondre($etudiant_id, $classe_id, $tp_id,Input::all());
		if($return === 'terminer') {
			return Redirect::route($this->base.'.index')->with('message_success', 'Vos réponses sont enregistrées');
		} elseif($return === 'sauvegarder') {
			return View::make($this->base.'.repondre', $this->gestion->repondre($etudiant_id, $classe_id, $tp_id, Input::get('pageCourante')) ); 				
		} elseif($return === 'suivant'){ //TODO checker que pagecourante est dans le bon range
			return View::make($this->base.'.repondre', $this->gestion->repondre($etudiant_id, $classe_id, $tp_id, Input::get('pageCourante')+1) ); 
		} elseif($return === 'precedent'){
			return View::make($this->base.'.repondre', $this->gestion->repondre($etudiant_id, $classe_id, $tp_id, Input::get('pageCourante')-1) );
		} else {
			return Redirect::route($this->base.'.index')->with('message_danger', "Une erreur grave c'est produite, veuillez avertir le professeur");
		}
	}
 
}
