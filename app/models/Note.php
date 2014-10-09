
<?php

class Note extends EloquentValidating
{
	
 /*
  * Mass assignment protection
  */
	protected $guarded = array('id');
	
/*
 * database relationships
 */
	
	// Une note est associée à un Classe/TP/Etudiant/Question
	public function classe() {
		return $this->belongsTo('Classe');
	}
	public function tp() {
		return $this->belongsTo('TP');
	}
	public function etudiant() {
		return $this->belongsTo('Etudiant');
	}
	public function question() {
		return $this->belongsTo('Question');
	}
	
	
/*
 * Validation
 * 
 * un note doit avoir: 
 *  classe_id : obligatoire
 *  tp_id : obligatoire
 *  etudiant_id : obligatoire
 *  question_id : obligatoire
 *  
 */	
	
	
	public function validationRules() {
		return [	 
			'classe_id'=>'required',
			'tp_id'=>'required',
			'etudiant_id'=>'required',
			'question_id'=>'required',
				
	];	
	}

}