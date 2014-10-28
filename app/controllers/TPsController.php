<?php
use Illuminate\Support\Facades;
/**
 * Le controller pour les travaux pratiques
 *
 *
 * @version 0.2
 * @author benou
 */

class TPsController extends BaseFilteredResourcesController
{
	
	public function __construct(TPsGestion $gestion) {
		//parent::__construct();
		$this->gestion = $gestion;
		$this->base = "tps";
		$this->message_store = 'Le travail pratique a été ajouté';
		$this->message_update = 'Le travail pratique a été modifié';
		$this->message_delete = 'Le travail pratique a été effacé';
		
	}

	
}