<?php

class TPsNotesController extends BaseController
{
	public function index($classeId, $tpId)
	{	
		/* afin d'afficher la page de correction pour un tp associé à une classe, je 
		 * dois aller chercher la classe, le tp associé à cette classe en passant par cette classe
		 * ensuite aller chercher les étudiants de cette classe et les questions de ce tp. 
		 * Je vérifie ensuite qu'il y'a une note pour l'ensemble de ces données (un étudiant ou une
		 * question ont pu être créés depuis la dernière correction) et je créé tout ce qui manque. 
		 * 
		 * Si une question a été supprimée depuis la dernière correction, j'efface simplement cette note. 
		 * 
		 */
		$classe = Classe::findOrFail($classeId); //TODO: catcher ModelNotFoundException
		$tp = $classe->tps()->where('tp_id', '=', $tpId)->first();
		$etudiants = $classe->etudiants;
		$questions = $tp->questions;
		/* vérification et ajout d'une note pour chaque tuplet classe/tp/etudiant/question */
		foreach($etudiants as $etudiant) {
			foreach($questions as $question) {
				
				$note = Note::where('classe_id', '=', $classeId)
							->where('tp_id', '=', $tpId)
							->where('etudiant_id', '=', $etudiant->id)
							->where('question_id', '=', $question->id )->first();
				if(!$note) {
					/* cette note n'existe pas, il faut donc la créer */
					$note = new Note;
					$note->classe_id = $classeId;
					$note->tp_id = $tpId;
					$note->etudiant_id = $etudiant->id;
					$note->question_id = $question->id;
					$note->note = 0;
					$note->commentaire = $question->baliseCorrection;
						
					$note->save();
				}
			}
		}
		
		//TODO: ajouter la logique pour les notes qui doivent être deleted
			
		return View::make('TPsNotes.index', compact('classe', 'tp', 'etudiants', 'questions')); 
	}
	
	public function edit($classeId, $tpId)
	{	
		$input = Input::all();
	 	
		if	(isset($input["corrigerQuestionEtudiant"])) {
		 	//TODO: ajouter la gestion si la var est pas set
			//TODO: ajouter le try catch si cette note n'est pas là
			
			// va chercher LA question pour CET étudiant
			$note = Note::where('classe_id', '=', $classeId)
						->where('tp_id', '=', $tpId)
						->where('etudiant_id', '=', $input['etudiants'])
						->where('question_id', '=', $input['questions'])->first();
			return View::make('TPsNotes.corrigeQuestionEtudiant', compact('note'));
		} else if (isset($input["corrigerEtudiant"])) {
			// va chercher LES questions pour CET étudiant
			$notes = Note::where('classe_id', '=', $classeId)
						->where('tp_id', '=', $tpId)
						->where('etudiant_id', '=', $input['etudiants'])->get();
			//TODO: ordonner selon l'ordre dans TPs_questions
			return View::make('TPsNotes.corrigeParEtudiant', compact('notes'));
			
		}	else if (isset($input["corrigerQuestion"])) {
			// va chercher CETTE questions pour CES étudiant
			$notes = Note::where('classe_id', '=', $classeId)
						->where('tp_id', '=', $tpId)
						->where('question_id', '=', $input['questions'])->get();
			return View::make('TPsNotes.corrigeParQuestion', compact('notes'));
				
		}
		
	}
	
	public function update()
	{
		$noteIds = Input::get('noteId');
		$notes = Input::get('note');
		$commentaires = Input::get('commentaire');
		for ($i=0; $i < count($noteIds);$i++)  {
			$note = Note::find($noteIds[$i]);
			$note->note = $notes[$i];
			$note->commentaire = $commentaires[$i];
			$note->save();
		}
		return Redirect::action('TPsNotesController@index', [$note->classe_id, $note->tp_id]);
	}
	
}