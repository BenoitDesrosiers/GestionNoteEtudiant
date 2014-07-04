<?php

class Classe extends Eloquent
{
 /*
  * Mass assignment protection
  */
	protected $guarded = array('id');
	
/*
 * database relationships
 */
	
	// Une classe a plusieurs Travaux Pratiques (TP)
	public function tps() {
		return $this->belongsToMany('TP', 'classes_tps');
	}
	
	
	
/*
 * Validation
 * 
 * une classe doit avoir: 
 * 	code: obligatoire, et unique dans toute la table
 *  nom : obligatoire
 *  session : obligatoire
 *  Les autres champs sont falcultatifs.  
 */	
	
	public static $validationMessages;
	
	public static function validationRules($id=0) {
		return [
			'code' => 'required|unique:classes,code'.($id ? ",$id" : ''),
			'nom'=>'required',
			'session'=>'required'
	];	
	}
	//TODO: ajouter une validation pour la session en regex
	
	//TODO: mettre cette fonction dans une superclasse
	
	public static function isValid($data, $id=0) {
		/*
		 * le paramêtre $id sert à faire la différence entre un update et un insert. 
		 * Si il est vide, alors c'est un create et il faut s'assurer que l'enregistrement est unique
		 * S'il est fournit, alors c'est un update, et on ne doit pas avoir un rejet parce que
		 * l'enregistrement existe déjà. La règle avec le 'unique" dans la validationRules est 
		 * concaténé avec cet id. Il sera donc exclue de la validation s'il existe. 
		 */
		$validation = Validator::make($data, static::validationRules($id));
		static::$validationMessages = $validation->messages();
		
		return $validation->passes();
	}
}