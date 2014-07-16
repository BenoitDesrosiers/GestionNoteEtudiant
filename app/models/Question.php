<?php

class Question extends Eloquent
{
	
 /*
  * Mass assignment protection
  */
	protected $guarded = array('id');
	
/*
 * database relationships
 */
	
	// Une question est associée à plusieurs TPs
	public function tps() {
		return $this->belongsToMany('TP', 'tps_questions', 'question_id', 'tp_id')->withPivot('ordre', 'sur_local');
	}
	
	
	
/*
 * Validation
 * 
 * un question doit avoir: 
 *  nom : obligatoire
 *  enonce : obligatoire
 *  sur : obligatoire
 *  
 */	
	
	public static $validationMessages;
	
	public static function validationRules($id=0) {
		return [	 
			'nom'=>'required',
			'enonce'=>'required',
			'sur'=>'required'
	];	
	}

	//TODO: mettre cette fonction dans une superclasse
	public static function isValid($data, $id=0) {
		
		$validation = Validator::make($data, static::validationRules($id));
		static::$validationMessages = $validation->messages();
		
		return $validation->passes();
	}
}