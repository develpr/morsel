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

	}

	public function show($id)
	{
		/** @var \Illuminate\Http\Request $request */
		$request = Request::create('/api/v1/messages/' . $id, 'GET');
		$this->api->dispatchRequest($request);

		$message = json_decode($this->api->getBody());

		$times = false;
		foreach($message->array as $input)
		{
			$times[] = $input->time;
		}

		$viewData = array(
			'message'	=> $message,
			'times'		=> $times,
		);

		$this->layout->content = View::make('messages.show')->with($viewData);
	}

	public function create()
	{
		$this->layout->content = View::make('messages.create');
	}

	public function createHard()
	{
		$this->layout->content = View::make('messages.createHardMode');
	}

	public function store()
	{
        $input = array();

        if(Input::has('text'))
		{
			if(strlen(Input::get('text')) > 70){
				return Redirect::to('/messages/create')->withErrors(array('test' => "Messages can't be any longer then 70 characters!"));
			}

            $input['text'] = Input::get('text');
		}

        else if(Input::has('raw'))
            $input['raw'] = Input::get('raw');

		/** @var \Illuminate\Http\Request $request */
		$request = Request::create('/api/v1/messages', 'POST', $input);
		$this->api->dispatchRequest($request);

		//A new message was created
		if($this->api->getStatusCode() == 201)
		{
			$message = json_decode($this->api->getBody());
			return Redirect::to('/messages/' . $message->id);
		}

	}



}