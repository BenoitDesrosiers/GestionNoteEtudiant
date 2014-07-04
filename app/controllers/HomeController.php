<?php

class HomeController extends BaseController {

	/*
	 * Le controller principale
	*/

	public function index()
	{
		return View::make('homePage');
	}

}
