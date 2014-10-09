<?php
/**
 * Le controller pour les travaux pratiques
 *
 *
 * @version 0.2
 * @author benou
 */

class TPsController extends BaseController
{
	/**
	 * Affichage de tous les Travaux Pratiques (TPs)
	 * 
	 * @param[in] get int belongsToId l'id de la classe à laquelle les travaux sont liés.
	 * 					Une valeur absente ou 0 indique d'afficher tous les travaux. 
	 */
	public function index()
	{	
		$belongsToList = createSelectList(Classe::all(), "id", ['code', 'nom'], "Tous");
		$belongsToSelectedId = checkLinkedId(0, Input::get('belongsToId'), 'Classe'); 
		return View::make('tps.index', compact('belongsToList', 'belongsToSelectedId')); 
	}
	
	/**
	 * Création d'un TP
	 *
	 * @param[in] get int belongsToId l'id de la classe qui sera sélectionnée pour être associé à ce TP.
	 * 					Une valeur absente ou 0 sera remplacée par la première classe de la liste des classes existantes.
	 */
	public function create()
	{
		$belongsToList = createSelectList(Classe::all(), "id", ['code', 'nom'], "Aucune classe");
		$belongsToSelectedIds = checkLinkedId(array_keys($belongsToList)[0], Input::get('belongsToId'), 'Classe');
		return View::make('tps.create', compact('belongsToList', 'belongsToSelectedIds'));
	}
	
	public function edit( $tpId)
	{
		$belongsToList = createSelectList(Classe::all(), "id", ['code', 'nom'], "Aucune classe");
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException
		$belongsToSelectedIds =  $tp->classes->fetch('id')->toArray();
		return View::make('tps.edit', compact( 'tp', 'belongsToList', 'belongsToSelectedIds'));
	}
	
	
	public function show( $tpId) 
	{
		$belongsToList = createSelectList(Classe::all(), "id", ['code', 'nom'], "Aucune classe");
		$tp = TP::findOrFail($tpId);
		$belongsToSelectedIds =  $tp->classes->fetch('id')->toArray();
		return View::make('tps.show', compact('tp', 'belongsToList', 'belongsToSelectedIds'));
	}	
	
	public function store()
	{
		$input = Input::all();
		$classeId = 0;
		//verifie que les ids de classe passé en paramêtre sont bons
		$classeIds = Input::get('belongsToListSelect', []);
		if(!allIdsExist($classeIds, 'Classe')){
				App::abort(404); //TODO afficher une meilleur page d'erreur
		}
		$tp = new TP;
		$tp->nom = $input['nom']; //TODO verifier que ce champ existe
		$tp->poids = $input['poids'];
			
		if($tp->save()) {
			foreach($classeIds as $classeId) {
				if($classeId <>0 ){
					//associe la classe au TP (many to many)
					$tp->classes()->attach($classeId, ['poids_local'=>$tp->poids]); // pour la création, je prends le poids du tp pour le poids local
				}
			}
			return Redirect::action('TPsController@index', array('belongsToId'=>$classeId));
		} else {		
			return Redirect::back()->withInput()->withErrors($tp->validationMessages);
		}			
	}
	
	
	public function update($tpId)
	{
		$input = Input::all();
		//verifie que les ids de classe passé en paramêtre sont bons
		$classeIds = Input::get('belongsToListSelect', []);
		if(!allIdsExist($classeIds, 'Classe')){
				App::abort(404); //TODO afficher une meilleur page d'erreur
		}
			
		$tp = TP::findOrFail($tpId); //TODO catch l'exception
		$tp->nom = $input['nom'];
		$tp->poids = $input['poids'];
		if($tp->save()) {
			$tp->classes()->sync($classeIds);	
			return Redirect::action('TPsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors($tp->validationMessages);
		}
	}
	
	public function destroy($tpId)
	{
		$tp = TP::findOrFail($tpId);
		$tp->classes()->detach();
		$tp->delete();
		// Détruit les notes associées à ce tp
		$notes = Note::where('tp_id', '=', $tpId)->get();
		foreach($notes as $note) {
			$note->delete();
		}
		
		return Redirect::action('TPsController@index');		
	}
	
/**
 * retourne la liste des TPs pour une classe en format JSON
 *
 * Doit être appelé par un call AJAX.
 *
 * @param[in] post int classeId l'id de la classe pour lequel on veut lister les TPs. La valeur 0 indique qu'on veut tous les TPs.
 * @return la sous-view pour afficher les items.
 *
 */
	
	public function tpsPourClasse() {
		if(Request::ajax()) {
			$belongsToId = Input::get('belongsToId');
			if($belongsToId <> 0) {
				try {
					$belongsTo = Classe::findOrFail($belongsToId);
				} catch (ModelNotFoundException $e) {
					return "la classe n'existe pas";
				}
				$tps = $belongsTo->tps;
			} else {
				$tps = TP::all();
			}
			return View::make('tps.listeTPs_subview')->with('tps',$tps)->with('belongsToId',$belongsToId);
	
		} else {
			return "vous n'avez pas les droits d'obtenir cette information";
		}
	}
	
}