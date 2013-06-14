<?php

namespace Morsel;
use \Request;
use \Route;
use \View;
use \Redirect;
use \Auth;
use \Input;


class UserController extends \BaseController{

	protected $api;
	protected $layout = 'layouts.master';


	public function __construct()
	{
		$this->api = new \ApiConnector();
	}


	/**
	 * If the user isn't logged in, send them to the create account page
	 */
	public function account()
	{
		//If the user isn't logged in, then we'll show the login/register related forms
		if(!Auth::check())
		{
			$this->layout->content = View::make('account.loginregister');
			return;
		}
	}


	public function login()
	{
		$user = Input::get('user');

		if (Auth::attempt($user))
		{
			return Redirect::to('/transmissions');
		}
		else
		{
			return Redirect::to('/account');
		}
	}


	public function register()
	{
		/** @var \Illuminate\Http\Request $request */
		$request = Request::create('/api/v1/users', 'POST', Input::all());

		$this->api->dispatchRequest($request);
		$response = $this->api->getResponse();

		if($response->getStatusCode() == 201)
		{
			return Redirect::to('/account')->with(array('message' => 'New account created successfully - login now'));
		}
		else
		{
			$errors = json_decode($response->getContent())->validationErrors;
			return Redirect::to('/account')->withInput(Input::except('pass'))->withErrors($errors);
		}

		$response->headers;
		$result = $response->getContent();

	}

	/**
	 * Edit account
	 */
	public function editBasicsView()
	{
		$this->layout->content = View::make('account.edit');
	}

	/**
	 *
	 * Handle editing the account
	 *
	 * @return mixed
	 */
	public function editBasicsPost()
	{
		$user = Auth::user();

		/** @var \Illuminate\Http\Request $request */
		$request = Request::create('/api/v1/users/' . $user->id, 'POST', Input::all());

		// Store the original input of the request and then replace the input with your request stores input.
		$originalInput = Request::input();

		Request::replace($request->input());

		// Dispatch your request store with the router.
		/** @var \Illuminate\Http\JsonResponse $response */
		$response = Route::dispatch($request);

		// Replace the input again with the original request input.
		Request::replace($originalInput);

		if($response->getStatusCode() == 204)
		{
			return Redirect::to('/my-account')->with(array('message' => 'Your account has been updated!'));
		}
		else
		{
			$errors = json_decode($response->getContent())->validationErrors;
			return Redirect::to('/my-account')->withInput(Input::except('pass'))->withErrors($errors);
		}

		$response->headers;
		$result = $response->getContent();
	}

}