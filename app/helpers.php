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

/**
 * helper pour créer les select dans les views utilisant des classes.
 */

/**
 * Création de la liste utilisée dans le select pour choisir une classe
 *
 * Je n'ai pas trouvé comment en faire une fonction générique à cause du fait que j'ai besoin de sessionscholaire->nom. Je vois
 * comment passer les colonnes, mais pas ->sessionscholaire->nom
 *  
 * @param collection $items la collection des classes à afficher
 * @param string $valeur0 optionnelle, si utilisée, ca sera la valeur à l'indice 0 dans le select
 * @return array l'array à utiliser dans le select. Contient l'indice et le texte à afficher basé sur certaines colonnes des classes.
 */

function createBelongsToListForClasses($items, $valeur0=null) {
	if(isset($valeur0)) {
		$belongsToList[0]=$valeur0;
	}
	foreach($items as $item) {
		$belongsToList[$item->id]=$item->sessionscholaire->nom." ". $item->code." ".$item->nom;
	}
	return $belongsToList;
}

/**
 * Regroupement des classes par sessioncholaire
 * @param boolean $tous Est-ce que la liste doit avoir un choix "Tous"
 * @return une array associative:
 * 			"groupes" => une array bidimensionnelle dont la clé de la première dimension est l'id de la session,
 * 						 et la deuxième dimension contient les ids des classes associées à cette session.
 * 			"selectList" =>  une array dont la clé est l'id de chaque sessions, et la valeur est le nom de cette session.
 * 							 cette array est parfaite pour être utilisée dans un select sur une view.
 *
 */
function createFiltreParSessionPourClasses($classes, $tous) {
	$groupes=[];
	$selectList=[];
	if($tous)
	{$selectList['tous']="Tous";}
	foreach($classes as $classe) {
		if($tous)
		{$groupes["tous"][]=$classe->id;}
		$groupes[$classe->sessionscholaire->id][]=$classe->id;
		$selectList[$classe->sessionscholaire->id] = $classe->sessionscholaire->nom;
	}
	if($tous) { //ajoute l'id 0 à tous les groupes afin que "Tous" soit aussi sélectionné
		foreach($groupes as $key => $value) {
			$groupes[$key][]=0;
		}
	}
	$retour= ["groupes"=>$groupes, "selectList" => $selectList];
	return $retour;
}

