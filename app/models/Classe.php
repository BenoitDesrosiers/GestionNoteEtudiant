<?php
/**
 * Représente un cours à une période donnée
 * 
 * 
 * @author benou
 *
 */

class Classe extends EloquentValidating
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
		//TODO: c'est pas belongsToMany, c'est hasMany ... le CHANGER
		return $this->belongsToMany('TP', 'classes_tps', 'classe_id', 'tp_id')->withPivot('poids_local'); //encore ici, je suis obligé de spécifier tp_id, sinon, la clé est t_p_id ????
	}
	
	// Une classe a plusieurs étudiants d'inscrit
	
	public function etudiants() {
		return $this->belongsToMany('Etudiant', 'etudiants_classes', 'classe_id', 'etudiant_id');
	}
	
	// Une classe appartient à une session
	public function sessionscholaire() {
		return $this->belongsTo('Sessionscholaire');
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
	
	
	public function validationRules() {
		return [
			'code' => 'required|unique:classes,code'.($this->id ? ",$this->id" : ''),
			'nom'=>'required',
	];	
	}
	
}