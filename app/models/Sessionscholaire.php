
<?php

class Sessionscholaire extends EloquentValidating
{
	
 /*
  * Mass assignment protection
  */
	protected $guarded = array('id');
	
/*
 * database relationships
 */
	
	// Une session est associée à plusieurs Classe
	public function classes() {
		return $this->hasMany('Classe');
	}

	
	
/*
 * Validation
 * 
 * aucune règle
 *  
 */	
	
	
	public function validationRules() {
		return [	 
				];	
	}

}