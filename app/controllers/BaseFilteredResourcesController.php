<?php

/**
 * Classe abstraite permettant de controller une ressource pouvant être filtrer par un call Ajax
 * 
 * @version 0.1
 * @author benou
 *
 */

class BaseFilteredResourcesController extends BaseResourcesController
{
	

/**
 * AJAX
 * 
 */
	
	
/**
 * retourne le code HTML pour afficher une liste d'items selon les filtres sélectionnés à l'écran 
 * Doit être appelé par un call AJAX
 * 
 * @param[in] post int belongsToId un id de la classe par lequel filtrer les items. La valeur 0 indique qu'on veut tous les items.
 * @param[in] post int filter1Select la valeur secondaire par laquelle filtrer. 
 * @return la sous-view en code HTML pour afficher les items.
 */
	
	public function itemsFor2Filters() {
		if(1==1 or Request::ajax()) { //TODO: enlever 1==1
			return View::make($this->base.'.index_subview', $this->gestion->itemsFor2Filters(Input::get('belongsToId'), Input::get('filtre1Select')));
		} else { //si le call n'est pas ajax.
			return "vous n'avez pas les droits d'obtenir cette information";
		}
	}
}