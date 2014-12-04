<?php
use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
 
class User extends Eloquent implements ConfideUserInterface {
    use ConfideUser;
    
    

    /*
     * database relationships
    */
    
    // Un étudiant est associée à plusieurs Classe
    public function classes() {
    	return $this->belongsToMany('Classe', 'etudiants_classes', 'etudiant_id', 'classe_id');
    }
    
    
    /*
     * scope
     */
    
    public function scopeEtudiant($query) {
    	return $query->where('type',"=","e");
    }
    
    public function scopeEnseignant($query) {
    	return $query->where('type',"=","p");
    }
}
