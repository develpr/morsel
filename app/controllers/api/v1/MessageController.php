<?php

namespace Morsel\Api\V1;
use \Input;
use \Auth;
use Morsel\Decoder;
use Morsel\Encoder;
use Morsel\Message;
use Morsel\Transmission;
use \Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

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
		$limit = 10;
		$skip = 0;
		if(Input::has('limit'))
			$limit = Input::get('limit');

		if(Input::has('skip'))
			$skip = Input::get('skip');

		$messages = Auth::user()->messages()->orderBy('created_at', 'desc')->skip($skip)->take($limit)->get();

		return Response::json($messages, 200);

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
			$array = $encoder->getInputArray();
		}

		$message = new Message();
		$message->method = $method;
		$message->raw = $raw;
		$message->array = $array;
		$message->morse = $morse;
		$message->text = $text;

		$user = Auth::user();
		$message->user()->associate($user);

		$message->save();

		$mate = Auth::user()->mate;

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

		if(!$message)
		{
//			$response = array(
//				'error' => true,
//				'http_status' => 404,
//				'errorMessage' => 'Unable to location this message'
//			);
//			return Response::json($response, 404);
			throw new ResourceNotFoundException('Unable to location this message');
		}

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