<?php

/**
 * Le controller pour les questions
 * 
 * @version 0.1
 * @author benou
 *
 */
class QuestionsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$questions = Question::all();
		return View::make('questions.index', compact('questions'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('questions.create');
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		
		if (Question::isValid($input)) {
			$question = new Question;
			$question->nom = $input['nom'];			
			$question->enonce = $input['enonce'];
			$question->baliseCorrection = $input['baliseCorrection'];
			$question->reponse = $input['reponse'];
			$question->sur = $input['sur'];
			
			$question->save();
			
			return Redirect::action('QuestionsController@index');
		}
	
		return Redirect::back()->withInput()->withErrors(Question::$validationMessages);				
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$question = Question::findOrFail($id); //TODO: catcher ModelNotFoundException
		return View::make('questions.show', compact( 'question'));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$question = Question::findOrFail($id); //TODO: catcher ModelNotFoundException
		return View::make('questions.edit', compact( 'question'));	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
				
		if (Question::isValid($input,$id)) { 
			$question = Question::findOrFail($id);
			$question->nom = $input['nom'];
			$question->enonce = $input['enonce'];
			$question->baliseCorrection = $input['baliseCorrection'];
			$question->reponse = $input['reponse'];
			$question->sur = $input['sur'];
			$question->save(); 
		
			return Redirect::action('QuestionsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors(Question::$validationMessages);
		}	
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$question = Question::findOrFail($id);
		$question->tps()->detach();
		$question->delete();
		
		// Détruit les notes associées à cette question
		$notes = Note::where('question_id', '=', $id)->get();
		foreach($notes as $note) {
			$note->delete();
		}
		
		return Redirect::action('QuestionsController@index');			
	}

}
