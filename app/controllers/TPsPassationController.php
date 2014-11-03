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

	public function repondre($etudiant_id, $classe_id, $tp_id) {
		dd($etudiant_id.' '.$classe_id.' '.$tp_id);
	}
 	
 
}
