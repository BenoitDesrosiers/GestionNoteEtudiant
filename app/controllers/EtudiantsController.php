<?php
/**
 * Le controller pour les étudiants
 * 
 * 
 * @version 0.1
 * @author benou
 *
 */
class EtudiantsController extends BaseResourcesController {

	public function __construct(EtudiantsGestion $gestion) {
		//parent::__construct();
		$this->gestion = $gestion;
		$this->base = "etudiants";
		$this->message_store = "L'étudiant a été ajouté";
		$this->message_update = "L'étudiant a été modifié";
		$this->message_delete = "L'étudiant a été effacé";
	}
	

	/**
	 * retourne la liste des étudiants pour une classe en format JSON
	 *
	 * Doit être appelé par un call AJAX.
	 *
	 * @param[in] post int belongsToId l'id de la classe pour lequel on veut lister les étudiants. 
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
			return View::make('etudiants.listeEtudiants_subview')->with('lignes',$etudiants)->with('belongsToId',$belongsToId);
	
		} else {
			return "vous n'avez pas les droits d'obtenir cette information";
		}
	}
	
	static function createOptionsValue($item) {
		return $item->sessionscholaire->nom." ". $item->code." ".$item->nom;
	}

}
