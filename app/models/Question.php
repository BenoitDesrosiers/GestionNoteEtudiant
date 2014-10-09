<?php

class Question extends EloquentValidating
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
	
	
	public function validationRules() {
		return [	 
			'nom'=>'required',
			'enonce'=>'required',
			'sur'=>'required'
	];	
	}
}