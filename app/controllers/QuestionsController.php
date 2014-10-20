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
		return $this->displayView('questions.index', 'Tous');
		
		/*$questions = Question::all();
		return View::make('questions.index', compact('questions'));*/
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return $this->displayView('questions.create', 'Aucun TP');
				
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
		return $this->displayView('questions.edit', 'Aucun TP', Question::findOrFail($id));
	}
	
	
	private function displayView($view, $option0, $item=null, $displayOnlyLinked=null) {
		if(isset($item) and isset($displayOnlyLinked) ) {
			$lesTPs = $item->tps;//affiche seulement les tps associées à cet item. (utile pour show)
		} else {//sinon affiche tous.
			$lesTPs = TP::all()->sortby("nom");
		}
		$belongsToList = createSelectOptions($lesTPs,[get_class(), 'createOptionsValue'], $option0);
		if(isset($item)) { //si on a un item, on sélectionne seulement ce qui est associées
			$belongsToSelectedIds =  $item->TPs->fetch('id')->toArray();
		} else { //sinon, on sélectionne ce qui a été passée en paramêtre (si c'est bon, sinon, la première de la liste
			$belongsToSelectedIds = checkLinkedId(array_keys($belongsToList)[0], Input::get('belongsToId'), 'TP');
		}
		$filtre1 = createFiltreParClassePourTP($lesTPs, true);
		$question = $item;
		return View::make($view, compact('question', 'belongsToList', 'belongsToSelectedIds','filtre1'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		
		$tpId = 0;
		//vérifie que les ids de TP passés en paramêtre sont bons
		$tpIds = Input::get('belongsToListSelect',[]);
		if(!allIdsExist($tpIds, 'TP')) {
			return View::make("erreurSysteme");
		}
		
		$question = new Question;
		if($question->createWithTPs($input, $tpIds)) {
			return Redirect::action('QuestionsController@index', array('belongsToId'=>$tpId));
		} else {
			return Redirect::back()->withInput()->withErrors($question->validationMessages);				
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		//vérifie que les ids de TP passés en paramêtre sont bons
		$tpIds = Input::get('belongsToListSelect',[]);
		if(!allIdsExist($tpIds, 'TP')) {
			return View::make("erreurSysteme");
		}
		
		$question = Question::findOrFail($id);
		if($question->updateForTPs($input,$tpIds)) {			
			return Redirect::action('QuestionsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($question->validationMessages);
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
		$question->tps()->detach(); //TODO: resynch l'ordre
		$question->delete(); 
		
		// Détruit les notes associées à cette question
		$notes = Note::where('question_id', '=', $id)->get();
		foreach($notes as $note) {
			$note->delete();
		}
		
		return Redirect::action('QuestionsController@index');			
	}

	/**
	 * retourne la liste des Questions pour un TP en format JSON
	 *
	 * Doit être appelé par un call AJAX.
	 *
	 * @param[in] post int belongsToId l'id du TP pour lequel on veut lister les Questions. La valeur 0 indique qu'on veut tous les Questions.
	 * @return la sous-view pour afficher les items.
	 *
	 */
	
	public function questionsPourTPs() {
		if(Request::ajax()) {
			$belongsToId = Input::get('belongsToId');
		//dd('belongsToid '.$belongsToId."  ".Input::get('filtre1Select'));
			if($belongsToId <> 0) { //Si un TP en particulier est sélectionné, retourne les questions pour celui-ci
				try {
					$belongsTo = TP::findOrFail($belongsToId);
				} catch (ModelNotFoundException $e) {
					return "le TP n'existe pas";
				}
				$questions = $belongsTo->questions;
			} else { //affiche tous les questions pour tous les TPs
				$filtre1Value = Input::get('filtre1Select'); //filtre1 est pour la classe
				if($filtre1Value==0) { //si il n'y a pas de classe de sélectionnée, on prends tous les questions
					$questions = Question::all();
				} else {//une classe est sélectionnée, on affiche donc uniquement les questions des TPs de cette classe 
					$tps = Classe::find($filtre1Value)->tps; 
					$questionsIds = [];
					foreach($tps as $tp) { //créé la liste des ids des questions pour tous ces TPs.
						$questionsIds=array_merge($questionsIds,$tp->questions->lists('id'));
					}
					//une questions peut être avec 2 TPs, il faut donc aller les chercher par leur id afin d'enlever les doublons
					if(count($questionsIds)>0) {
						$questions = Question::whereIn('id', $questionsIds)->get();
					} else {
						$questions = new Illuminate\Database\Eloquent\Collection;
					}
						
				}
			}
			return View::make('questions.listeQuestions_subview')->with('questions',$questions->sortBy("id"))->with('belongsToId',$belongsToId);
	
		} else { //si le call n'est pas ajax.
			return "vous n'avez pas les droits d'obtenir cette information";
		}
	}
	/**
	 * Helpers
	 *
	 */
	static function createOptionsValue($item) {
		return $item->nom;
	}
	
}
