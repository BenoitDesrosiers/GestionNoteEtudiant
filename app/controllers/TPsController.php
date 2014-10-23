<?php
use Illuminate\Support\Facades;
/**
 * Le controller pour les travaux pratiques
 *
 *
 * @version 0.2
 * @author benou
 */

class TPsController extends BaseResourcesController
{
	
	public function __construct(TPsGestion $gestion) {
		//parent::__construct();
		$this->gestion = $gestion;
		$this->base = "tps";
		$this->message_store = 'Le travail pratique a été ajouté';
		$this->message_update = 'Le travail pratique a été modifié';
		$this->message_delete = 'Le travail pratique a été effacé';
	}


	
/**
 * retourne la liste des TPs pour une classe en format JSON
 *
 * Doit être appelé par un call AJAX.
 *
 * @param[in] post int belongsToId l'id de la classe pour lequel on veut lister les TPs. La valeur 0 indique qu'on veut tous les TPs.
 * @return la sous-view pour afficher les items.
 *
 */
	
	public function tpsPourClasse() {
		if(1==1 or Request::ajax()) {
			$belongsToId = Input::get('belongsToId');
			if($belongsToId <> 0) { //Si une classe en particulier est sélectionnée, retourne les TPs pour celle-ci
				try {
					$belongsTo = Classe::findOrFail($belongsToId);
				} catch (ModelNotFoundException $e) {
					return "la classe n'existe pas";
				}
				$lignes = $belongsTo->tps;
			} else { //affiche tous les TPs pour toutes les classes
				$filtre1Value = Input::get('filtre1Select'); //filtre1 est pour la session scholaire
				if($filtre1Value==0) { //si il n'y a pas de session de sélectionnée, on prends tous les TPs
					$lignes = TP::all();
				} else {//une session est sélectionnée, on affiche donc uniquement les TPs des classes pour cette session
					$classes = Classe::where('sessionscholaire_id', '=' , $filtre1Value)->get(); //va chercher les classes pour cette session
					$tpIds = [];
					foreach($classes as $classe) { //créé la liste des ids des TPs pour toutes ces classes.
						$tpIds=array_merge($tpIds,$classe->tps->lists('id'));
					}
					//un TP peut être avec 2 classes, il faut donc aller les chercher par leur id afin d'enlever les doublons
					if(count($tpId)>0) {
						$lignes = TP::whereIn('id', $tpIds)->get();
					} else {
						$lignes = new Illuminate\Database\Eloquent\Collection; 
					}
				}
			}
			return View::make('tps.listeTPs_subview')->with('lignes',$lignes->sortBy("nom"))->with('belongsToId',$belongsToId);
	
		} else { //si le call n'est pas ajax.
			return "vous n'avez pas les droits d'obtenir cette information";
		}
	}
	

	
}