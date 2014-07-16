<?php

class Etudiant extends Eloquent
{
	
 /*
  * Mass assignment protection
  */
	protected $guarded = array('id');
	
/*
 * database relationships
 */
	
	// Un étudiant est associée à plusieurs Classe
	public function classes() {
		return $this->belongsToMany('Classe', 'etudiants_classes', 'etudiant_id', 'classe_id');
	}
	
	
	
/*
 * Validation
 * 
 * un étudiant doit avoir: 
 *  nom : obligatoire
 *  da : obligatoire (numéro d'identification (Date d'Admission)
 *  
 */	
	
	public static $validationMessages;
	
	public static function validationRules($id=0) {
		return [	 
			'nom'=>'required',
			'da'=>'required',
	];	
	}

	//TODO: mettre cette fonction dans une superclasse
	public static function isValid($data, $id=0) {
		
		$validation = Validator::make($data, static::validationRules($id));
		static::$validationMessages = $validation->messages();
		
		return $validation->passes();
	}
}