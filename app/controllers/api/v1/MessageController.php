<?php

namespace Morsel\Api\V1;
use \Input;
use Morsel\Decoder;
use Morsel\Encoder;
use Morsel\Message;
use Morsel\Transmission;
use \Response;

class MessageController extends \BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth.admin', array('only' =>
		array('index', 'restart')));

		$this->beforeFilter('auth.message', array('only' =>
		array('show', 'edit', 'update', 'destroy')));

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$hi = "HI";
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$raw = '';
		$array = '';
		$morse = '';
		$text = '';
		$method = '';
		//First, let's see if we need to decode the message
		if(Input::has('raw'))
		{
			$method = 'intervals';
			//yep!
			//todo: make this a static helper of some sort so we don't have to create a new Decoder/Encoder instance
			$decoder = new Decoder();
			$raw = Input::get('raw');
			$decoder->setRawInput($raw);
			$array = $decoder->getInputArray();
			$text = $decoder->decode();
			$morse = $decoder->getMorse();

		}
		//Else we need to encode the message to make it interesting/universal
		else if(Input::has('text'))
		{
			$method = 'text';

			$encoder = new Encoder();
			$encoder->setTextMessage(Input::get('text'));
			$encoder->encode();
			$morse = $encoder->getMorse();
			$text = Input::get('text');
			$raw = $encoder->getRaw();
			$array = array(); //todo: do we care about encoding this?
		}

		$message = new Message();
		$message->method = $method;
		$message->raw = $raw;
		$message->array = $array;
		$message->morse = $morse;
		$message->text = $text;

		$user = \Auth::user();
		$message->user()->associate($user);

		$message->save();

		$mate = \Auth::user()->mate;

		//The user has a mate, so we'll add a transmission record for them to pick up
		if($mate)
		{
			$transmission = new Transmission();
			$transmission->message()->associate($message);
			$transmission->sender()->associate($user);
			$transmission->receiver()->associate($mate);
			$transmission->save();
		}

		return Response::json($message, 201, array('Location' => '/api/v1/messages/'.$message->id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$message = Message::find($id);

		return Response::json($message);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}