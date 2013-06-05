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

		$decoder = new Decoder();

		$decoder->setRawInput($message->raw);
		$text = $decoder->decode();

		$times = array();
		foreach($decoder->getInputArray() as $input)
		{
			$times[] = $input['time'];
		}

		$viewData = array(
			'message'	=> $message,
			'text'		=> $text,
			'rawArray'	=> $decoder->getInputArray(),
			'times'		=> $times
		);

		$this->layout->content = View::make('messages.show')->with($viewData);
	}



}