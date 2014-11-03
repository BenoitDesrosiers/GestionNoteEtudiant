<?php

class HomeController extends BaseController {

	/*
	 * Le controller principale
	*/

	public function index()
	{
		if(Auth::user()->type == 'p') {
			return View::make('homePageProf');
		} else {
			return View::make('homePageEtudiant');
		}
	}

}
