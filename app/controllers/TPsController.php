<?php

class TPsController extends BaseController
{
	public function index()
	{	
		$tps = TP::all();
		return View::make('tps.index', compact('tps')); 
	}
	
	public function create()
	{
		return View::make('tps.create');
	}
	
	public function edit( $tpId)
	{
		$tp = TP::findOrFail($tpId); //TODO: catcher ModelNotFoundException
		return View::make('tps.edit', compact( 'tp'));
	}
	
	
	public function show( $tpId) 
	{
		$tp = TP::findOrFail($tpId);
		return View::make('tps.show', compact('tp'));
	}	
	
	public function store()
	{
		
		$input = Input::all();
		
		if (TP::isValid($input)) {
			$tp = new TP;
			$tp->nom = $input['nom'];
			$tp->sur = $input['sur'];
			$tp->poids = $input['poids'];
			
			$tp->save();
			
			return Redirect::action('TPsController@index');
		}
	
		return Redirect::back()->withInput()->withErrors(TP::$validationMessages);
				
	}
	
	
	public function update($tpId)
	{
		$input = Input::all();
				
		if (TP::isValid($input,$tpId)) { 
			$tp = TP::findOrFail($tpId);
			$tp->nom = $input['nom'];
			$tp->sur = $input['sur'];
			$tp->poids = $input['poids'];
			$tp->save(); 
		
			return Redirect::action('TPsController@index');
		} else {
			return Redirect::back()->withInput()->withErrors(TP::$validationMessages);
		}
	}
	
	public function destroy($tpId)
	{
		$tp = TP::findOrFail($tpId);
		$tp->delete();
		
		return Redirect::action('TPsController@index');		
	}
}