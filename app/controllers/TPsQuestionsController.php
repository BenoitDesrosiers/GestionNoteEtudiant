<?php

class TPsQuestionsController extends BaseController
{
	public function index($tpId)
	{	
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException
		$questions = $tp->questions()->orderBy('pivot_ordre')->get(); 
		return View::make('TPsQuestions.index', compact('tp','questions')); 
	}
	
	public function create($tpId)
	{
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException
		return View::make('TPsQuestions.create', compact('tp'));
	}
	
	public function edit($tpId, $questionId)
	{
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException
		$question = $tp->questions()->where('question_id', '=', $questionId)->first();
		return View::make('TPsQuestions.edit', compact('tp', 'question'));
	}
	
	
	public function show($tpId, $questionId) 
	{
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException
		$question = $tp->Questions()->where('question_id', '=', $questionId)->first();
		return View::make('TPsQuestions.show', compact('tp', 'question'));
	}	
	
	public function store($tpId)
	{
		
		$tp = TP::findOrFail($tpId); //juste pour s'assurer que l'id de TP passé en paramêtre est valide, sinon: 404. 
		//TODO: catcher ModelNotFoundException
		$input = Input::all();
		
		if (Question::isValid($input)) {
			$question = new Question;
			$question->nom = $input['nom'];
			$question->enonce = $input['enonce'];
			$question->baliseCorrection = $input['baliseCorrection'];
			$question->reponse = $input['reponse'];
			$question->sur = $input['sur'];
			
			$question->save();
			
			//associe la TP au Question (many to many)
			$question->TPs()->attach($tpId, ['sur_local'=>$question->sur]); // TODO: calculer l'ordre de la question
			
			return Redirect::action('TPsQuestionsController@index', $tpId);
		}
	
		return Redirect::back()->withInput()->withErrors(Question::$validationMessages);
				
	}
	
	
	public function update($tpId, $questionId)
	{
		$tp = TP::findOrFail($tpId); //juste pour s'assurer que l'id de TP passé en paramêtre est valide, sinon: 404.
		//TODO: catcher ModelNotFoundException
		$input = Input::all();
				
		if (Question::isValid($input,$questionId)) { 
			$question = $tp->Questions()->where('Question_id', '=', $questionId)->first();
			$question->nom = $input['nom'];
			$question->enonce = $input['enonce'];
			$question->sur = $input['sur'];
			$question->baliseCorrection = $input['baliseCorrection'];
			$question->reponse = $input['reponse'];
			$question->save(); 
			
			$question->pivot->sur_local = $input['sur_local'];
			$question->pivot->ordre = $input['ordre'];
			$question->pivot->save();
		
			return Redirect::action('TPsQuestionsController@index', $tpId);
		} else {
			return Redirect::back()->withInput()->withErrors(Question::$validationMessages);
		}
	}
	
	public function destroy($tpId, $questionId)
	{
		$question = Question::findOrFail($questionId);
		$question->tps()->detach();
		$question->delete();
		
		return Redirect::action('TPsQuestionsController@index', $tpId);		
	}
	
	
	public function connect($tpId)
	{
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException
		$questions = Question::all();
		return View::make('TPsQuestions.connect', compact('tp', 'questions'));
	}
	
	public function doConnect($tpId)
	{
		$input= Input::all();
		
		if (isset($input['selectionTP'])) {
			TP::find($tpId)->questions()->sync($input['selectionTP']);
		}
		return Redirect::action('TPsQuestionsController@index', $tpId);
		
	}
	
	
	public function disconnect($tpId, $questionId)
	{
		// Déconnecte un Question d'une TP sans effacer le Question
		$question = Question::findOrFail($questionId);
		$question->TPs()->detach($tpId);
		
		return Redirect::action('TPsQuestionsController@index', $tpId);
	}
}