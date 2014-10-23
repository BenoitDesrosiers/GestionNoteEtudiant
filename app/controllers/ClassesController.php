<?php

/**
 * Le controller pour les classes
 * 
 * @version 0.1
 * @author benou
 *
 */

class ClassesController extends BaseResourcesController
{
	public function __construct(ClassesGestion $gestion) {
		//parent::__construct();
		$this->gestion = $gestion;
		$this->base = "classes"; 
		$this->message_store = 'La classe a été ajoutée';
		$this->message_update = 'La classe a été modifiée';
	}
	
	
	public function destroy($id)
	{
		$classe = Classe::findOrFail($id);
		$classe->tps()->detach();
		
		$classe->delete();
		
		// Détruit les notes associées à cette classes
		$notes = Note::where('classe_id', '=', $id)->get();
		foreach($notes as $note) {
			$note->delete();
		}
		return Redirect::action('ClassesController@index');		
	}
}