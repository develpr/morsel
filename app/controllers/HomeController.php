<?php

namespace Morsel;
use \Request;
use \Route;
use \View;
use \Redirect;
use \Auth;
use \Input;

class HomeController extends \BaseController {

	protected $api;
	protected $layout = 'layouts.master';


	public function __construct()
	{
		$this->api = new \ApiConnector();
	}


	public function home()
	{
		if(Auth::check())
		{
			return Redirect::to('/transmissions');
		}

		$this->layout->content = View::make('home');
	}


}