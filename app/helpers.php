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





