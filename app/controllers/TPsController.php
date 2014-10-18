<?php
use Illuminate\Support\Facades;
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
		$lesClasses = Classe::all()->sortby("sessionscholaire_id"); //ce n'est pas exactement par session, mais si les id sont dans le bon ordre, ca le sera. 
		$belongsToList=createBelongsToListForClasses($lesClasses, "Tous");
		$belongsToSelectedId = checkLinkedId(0, Input::get('belongsToId'), 'Classe'); 
		$filtre1 = createFiltreParSessionPourClasses($lesClasses, true);
		return View::make('tps.index', compact('belongsToList', 'belongsToSelectedId','filtre1')); 
	}
	
	/**
	 * Création d'un TP
	 *
	 * @param[in] get int belongsToId l'id de la classe qui sera sélectionnée pour être associé à ce TP.
	 * 					Une valeur absente ou 0 sera remplacée par la première classe de la liste des classes existantes.
	 */
	public function create()
	{
		$lesClasses = Classe::all();
		$belongsToList=createBelongsToListForClasses($lesClasses, "Aucune classe");
		$belongsToSelectedIds = checkLinkedId(array_keys($belongsToList)[0], Input::get('belongsToId'), 'Classe');
		$filtre1 = createFiltreParSessionPourClasses($lesClasses, true);
		return View::make('tps.create', compact('belongsToList', 'belongsToSelectedIds','filtre1'));
	}
	
	public function edit( $tpId)
	{
		$lesClasses = Classe::all();
		$belongsToList=createBelongsToListForClasses($lesClasses, "Aucune classe");
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException
		$belongsToSelectedIds =  $tp->classes->fetch('id')->toArray();
		$filtre1 = createFiltreParSessionPourClasses($lesClasses, true);
		
		return View::make('tps.edit', compact( 'tp', 'belongsToList', 'belongsToSelectedIds','filtre1'));
	}
	
	
	public function show( $tpId) 
	{
		$tp = TP::findOrFail($tpId);
		$lesClasses = $tp->classes;
		$belongsToList=createBelongsToListForClasses($lesClasses);		
		$belongsToSelectedIds =  $tp->classes->fetch('id')->toArray();
		$filtre1 = createFiltreParSessionPourClasses($lesClasses, true);
		return View::make('tps.show', compact('tp', 'belongsToList', 'belongsToSelectedIds', 'filtre1'));
	}	
	
	
	/**
	 * Enregistrement initial dans la BD
	 * 
	 * 
	 * @param[in] get int belongsToListSelect les ids des classes auxquelles ce TP sera associé. 
	 * 					Si vide, alors le tp ne sera associé à rien. 
	 * 				 	Les ids doivent être valide, sinon une page d'erreur sera affichée.
	 * 
	 */
	public function store()
	{
		$input = Input::all();
		$classeId = 0;
		//verifie que les ids de classe passé en paramêtre sont bons
		$classeIds = Input::get('belongsToListSelect', []);
		if(!allIdsExist($classeIds, 'Classe')){
				return View::make("erreurSysteme"); 
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
				return View::make("erreurSysteme"); 
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
			if($belongsToId <> 0) { //Si une classe en particulier est sélectionnée, retourne les TPs pour celle-ci
				try {
					$belongsTo = Classe::findOrFail($belongsToId);
				} catch (ModelNotFoundException $e) {
					return "la classe n'existe pas";
				}
				$tps = $belongsTo->tps;
			} else { //affiche tous les TPs pour toutes les classes
				$filtre1Value = Input::get('filtre1Select'); //filtre1 est pour la session scholaire
				if($filtre1Value==0) { //si il n'y a pas de session de sélectionnée, on prends tous les TPs
					$tps = TP::all();
				} else {//une session est sélectionnée, on affiche donc uniquement les TPs des classes pour cette session
					$classes = Classe::where('sessionscholaire_id', '=' , $filtre1Value)->get(); //va chercher les classes pour cette session
					$tps = new Illuminate\Support\Collection;
					$tpIds = [];
					foreach($classes as $classe) { //créé la liste des ids des TPs pour toutes ces classes.
						$tpIds=array_merge($tpIds,$classe->tps->lists('id'));
					}
					//un TP peut être avec 2 classes, il faut donc aller les chercher par leur id afin d'enlever les doublons
					$tps = TP::whereIn('id', $tpIds)->get();
				}
			}
			return View::make('tps.listeTPs_subview')->with('tps',$tps->sortBy("nom"))->with('belongsToId',$belongsToId);
	
		} else { //si le call n'est pas ajax.
			return "vous n'avez pas les droits d'obtenir cette information";
		}
	}
	
	/**
	 * Helpers
	 * 
	 */
	

	
	
}