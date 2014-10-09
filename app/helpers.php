<?php
/**
 * vérifie si un objet de la classe $classe ayant l'id $itemId existe. 
 * Si oui, retourne $itemdId, si non, retourne $defaut
 *  
 * @param int $defaut la valeur a retourner si $itemId n'est pas bon.
 * @param int $itemId l'id de l'objet à vérifier
 * @param class $classe le nom de la classe à laquelle l'objet devrait appartenir
 * @return int $itemId ou $defaut
 */
function checkLinkedId($defaut, $itemId, $classe) {
	if($itemId <> 0) {
		//verifie que l'id passé en paramêtre existe.
		try {
			$item = $classe::findOrFail($itemId);
		} catch (Exception $e) {
			//si il n'existe pas, on prend celui du premier sport dans la liste
			$itemId = $defaut;
		}

	} else {
		//par default on prend la valeur par défaut
		$itemId= $defaut;
	}
	return $itemId;
}

/**
 * Crée une liste contenant un id et un valeur à afficher 
 * 
 * Pour l'instant, cette fonction est utilisée pour créer les items à afficher dans un select dans une view
 * 
 * @param string $items Les objets à partir desquels batir la liste.
 * @param string $cle Le nom de la colonne de l'objet contenant la clé qui sera associé à la valeur affichée
 * @param array $proprietes Le nom des propriétés à concaténer pour créer la valeur à afficher
 * @param string $tous Une ligne additionnelle qui aura l'indice 0. Si vide, alors il n'y a pas de ligne additionnelle. Utile pour ajouter "Toutes les valeurs".
 * @return array associative ayant pour clé les valeurs de la colonne $cle, et pour valeur la concaténation des $proprietes, et optionnelement une première 
 *                           ligne avec la clé 0 et la valeur $tous.
 */
function createSelectList($items, $cle, $proprietes, $tous = "") {
	$belongsToList = [];
	if($tous <> "") {
		$belongsToList[0] = $tous;	
	}	
	foreach($items as $item) {
		$texte = "";
		foreach($proprietes as $propriete) {
			$texte = $texte." ".$item->$propriete;
		}
		$belongsToList[$item->$cle] = $texte;
	}
	return $belongsToList;
}

/**
 * Vérifie que tous les $ids sont valide pour des objets de la classe $classe
 * @param array $ids une liste d'ids à vérifier
 * @param string $classe le nom de la classe. 
 * @return boolean Un objet doit exister avec chacun des ids pour que cette function retourne vrai
 */
function allIdsExist($ids, $classe ) {
		$retour = true;
		foreach($ids as $id) {
			if($id <> 0) {
				try { //verifie que la classe existe
					$dummy = $classe::findOrFail($id); //TODO optimiser pour ne pas créer les objets .. un simple select ferait l'affaire
				} catch (Exception $e) {
					$retour = false;
				}
			}
		}
	return $retour;
}