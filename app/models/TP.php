<?php

class TP extends Eloquent
{
	
	protected $table = 'tps';  // pour une raison x, le nom de la table par défaut était t_ps 
 /*
  * Mass assignment protection
  */
	protected $guarded = array('id');
	
/*
 * database relationships
 */
	
	// Un TP est associé à plusieurs classes
	public function classes() {
		return $this->belongsToMany('Classe', 'classes_tps', 'tp_id', 'classe_id'); //encore ici, je suis obligé de spécifier tp_id, sinon, la clé est t_p_id ????);
	}
	
	
	
/*
 * Validation
 * 
 * un TP doit avoir: 
 * 	numero: obligatoire, et unique pour une classe dans toute la table
 *  nom : obligatoire
 *  sur : obligatoire
 *  poids : obligatoire
 *  
 *  TODO: un numero de TP devrait être unique pour une classe 
 */	
	
	public static $validationMessages;
	
	public static function validationRules($id=0) {
		return [
			'numero' => 'required',
			//TODO: mettre le numero unique pour une classe...		|unique:classes,code'.($id ? ",$id" : ''),  	 
			'nom'=>'required',
			'sur'=>'required',
			'poids'=>'required'
	];	
	}

	//TODO: mettre cette fonction dans une superclasse
	public static function isValid($data, $id=0) {
		
		$validation = Validator::make($data, static::validationRules($id));
		static::$validationMessages = $validation->messages();
		
		return $validation->passes();
	}
}