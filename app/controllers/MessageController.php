<?php

namespace Morsel;
use \Request;
use \Route;
use \View;
use \Redirect;
use \Auth;
use \Input;

class MessageController extends \BaseController {

	protected $api;
	protected $layout = 'layouts.master';


	public function __construct()
	{
		$this->api = new \ApiConnector();
	}

	public function show($id)
	{
		$message = Message::find($id);

		$this->layout->content = View::make('home');
	}



}