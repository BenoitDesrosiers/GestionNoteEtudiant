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
	
	public function repondre( $classe_id, $tp_id) {
		//TODO: vérifie que les id sont bons. 
		return View::make($this->base.'.repondre', $this->gestion->repondre( $classe_id, $tp_id, 1) );
	}
 	
	public function doRepondre() {
		//les ids ont été sauvé dans la session afin de s'assurer que l'étudiant ne triche pas. 
		$pageCourante = Session::pull('pageCourante');
		$etudiant_id = Auth::user()->id;
		$classe_id = Session::pull('classeId');
		$tp_id = Session::pull('tpId');
		$input = Input::all();
		$return = $this->gestion->doRepondre(Input::get('reponse'), $etudiant_id, $classe_id, $tp_id, $pageCourante);
		if($return) {
			if(isset($input['sauvegarde'])) {
				return View::make($this->base.'.repondre', $this->gestion->repondre($classe_id, $tp_id, $pageCourante) ); 				
			} elseif(isset($input['suivant'])){
				return View::make($this->base.'.repondre', $this->gestion->repondre($classe_id, $tp_id, $pageCourante+1) ); 
			} elseif(isset($input['precedent'])) {
				return View::make($this->base.'.repondre', $this->gestion->repondre($classe_id, $tp_id, $pageCourante-1) );
			} else {
				return Redirect::route($this->base.'.index')->with('message_success', 'Vos réponses sont enregistrées');
			}
		} else {
			return Redirect::route($this->base.'.index')->with('message_danger', "Une erreur grave c'est produite, veuillez avertir le professeur");
		}
	}
 
	
	public function voirCorrection( $classe_id, $tp_id) {
		//TODO: vérifie que les id sont bons.
		//voir les réponses utilise "repondre" car j'ai juste besoin d'aller chercher la bonne réponse, la note, et le commentaire
		return View::make($this->base.'.voirCorrection', $this->gestion->repondre( $classe_id, $tp_id, 1) );
	}
	public function voirSuiteCorrection() {
		$pageCourante = Session::pull('pageCourante');
		$etudiant_id = Auth::user()->id;
		$classe_id = Session::pull('classeId');
		$tp_id = Session::pull('tpId');
		$input = Input::all();

		if(isset($input['suivant'])){
			return View::make($this->base.'.voirCorrection', $this->gestion->repondre($classe_id, $tp_id, $pageCourante+1) );
		} elseif(isset($input['precedent'])) {
			return View::make($this->base.'.voirCorrection', $this->gestion->repondre($classe_id, $tp_id, $pageCourante-1) );
		} else {
			return Redirect::route($this->base.'.index');
		}
		
	}
}
