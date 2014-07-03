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
		return $this->hasMany('TP');
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
	#TODO: ajouter une validation pour la session en regex
	
	public static function isValid($data, $id=0) {
		
		$validation = Validator::make($data, static::validationRules($id));
		static::$validationMessages = $validation->messages();
		
		return $validation->passes();
	}
}