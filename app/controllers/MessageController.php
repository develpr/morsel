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

	public function index()
	{
		/** @var \Illuminate\Http\Request $request */
		$request = Request::create('/api/v1/messages', 'GET');
		$this->api->dispatchRequest($request);

		$messages = $this->api->getBody();

		$viewData = array(
			'messages' => $messages
		);

		$this->layout->content = View::make('messages.index')->with($viewData);
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
			'times'		=> $times,
			'averageDit'=> $decoder->getAverageDit(),
			'averageDah'=> $decoder->getAverageDah(),
			'longestMidCharacterPause' => $decoder->getLongestMidCharacterPause()
		);

		$this->layout->content = View::make('messages.show')->with($viewData);
	}



}