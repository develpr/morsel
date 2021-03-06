<?php

namespace Morsel\Api\V1;
use \Input;
use \Response;
use \User;
use \Auth;
use \Hash;
use \Crypt;

class UserController extends \BaseController {

	public function __construct()
	{
		$this->beforeFilter('auth.hmac', array('except' =>
		array('store')
		));

		$this->beforeFilter('auth.user.permission', array('only' =>
			array('show', 'edit', 'stores', 'update'))
		);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//todo: move to config
		$limit = 10;
		$offset = 0;

		if(Input::has('limit'))
			$limit = Input::get('limit');

		if(Input::has('offset'))
			$offset = Input::get('offset');

		$users = User::where('id', '>', 0)->skip($offset)->take($limit);

		if(!Input::has('username') && !Auth::user()->isAdmin())
			$users->where('id', '=', Auth::user()->id);
		else if(Input::has('username'))
			$users->where('username', '=', trim(Input::get('username')));

		//If the user is looking for a user based on username and if they are not themselves an admin, then only return
		//the data the we've deemed OK for them to view
		if(Input::has('username') && !Auth::user()->isAdmin())
			$users = array($users->first()->getPublicInfo());
		else
			$users = $users->get();

		return Response::json($users);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$user = new User(Input::all());

		$user->rules['pass'] = 'required|min:6|confirmed'; //we need to confirm the password
		//$user->rules['email'] = $user->rules['email'] . ',' . Auth::user()->id; //Ignore this user

		/** @var \Illuminate\Validation\Validator $validation */
		$validation = $user->validate();

		if($validation->fails())
		{
			$return = array(
				'error'         => true,
				'message'       => 'Your user input was invalid',
				'validationErrors' => $validation->errors()->getMessages()
			);
			return Response::json($return, 400);
		}
		else
		{
			$user->password = Hash::make($user->pass);

			$secretKey = Hash::make(str_random(8) . $user->password . time() . "heywhatsgoingon?");
            $secretKey = substr($secretKey, 10);
            $secretKey = substr($secretKey, 0, 4) . '-' . substr($secretKey, 4, 4) . '-' . substr($secretKey, 8, 4) . '-' . substr($secretKey, 12, 4);
            $user->secret_key = Crypt::encrypt($secretKey); //todo: encrypt this
			unset($user->pass);
			unset($user->pass_confirmation);
			$user->save();

			return Response::json($user, 201, array('Location' => '/api/v1/users/'.$user->id));
		}
	}

	public function stores(User $user)
	{
		$stores = $user->store;

		return Response::json($stores, 200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		/** @var User $user */
		$user = User::findOrFail($id);

		if(Auth::user()->id != $user->id && !Auth::user()->isAdmin())
			return Response::json($user->getPublicInfo());

		return Response::json($user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$user->fill(Input::all());

		if(Input::has('pass') && strlen(Input::get('pass') > 1))
		{
			$user->rules['pass'] = 'required|min:6|confirmed'; //we need to confirm the password
		}

		$user->rules['email'] = $user->rules['email'] . ',' . $user->id;
		$user->rules['username'] = $user->rules['username'] . ',' . $user->id;

		/** @var \Illuminate\Validation\Validator $validation */
		$validation = $user->validate();

		if($validation->fails())
		{
			$return = array(
				'error'         => true,
				'message'       => 'Your user input was invalid',
				'validationErrors' => $validation->errors()->getMessages()
			);
			return Response::json($return, 400);
		}
		else
		{
            if(Input::has('pass') && strlen(Input::get('pass') > 1))
			    $user->password = Hash::make($user->pass);

			unset($user->pass);
			unset($user->_method);
			unset($user->username);
			unset($user->pass_confirmation);
			$user->save();

			return Response::json($user, 204, array('Location' => '/api/v1/users/'.$user->id));
		}
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