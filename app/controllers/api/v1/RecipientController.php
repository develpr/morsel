<?php

namespace Morsel\Api\V1;
use \Input;
use \Response;
use \Auth;
use \DB;
use Symfony\Component\Finder\Exception\OperationNotPermitedException;
use Whoops\Example\Exception;

class RecipientController extends \BaseController{

	/**
	 *	returns the user that is logged in, or if it is passed in the user based on an ID
	 *
	 * @return User
	 */
	private function getUserFromScope()
	{
		if(Input::has('user') && Auth::user()->isAdmin())
			$user = User::findOrFail(Input::get('user'));
		else
			$user = Auth::user();

		return $user;
	}

	public function index()
	{
		$user = $this->getUserFromScope();

		return Response::json($user->recipients, 200);

	}

	public function store()
	{
		$user = $this->getUserFromScope();
		/** @var User $recipient */
		$recipient = \User::findOrFail(Input::get('new_recipient'));

		if($user->id == $recipient->id)
			throw new Exception();

		//todo: need to handle the case of duplicate entry exception being thrown
		$user->recipients()->attach($recipient->id);

		//We want to make sure we control what data is being sent back as we don't want to give too much information
		$basicRecipient = $recipient->getPublicInfo();

		return Response::json($basicRecipient, 201);

	}

	/**
	 * Unlink a recipient
	 *
	 * @param $id
	 * @return mixed
	 * @throws \Symfony\Component\Finder\Exception\OperationNotPermitedException
	 */
	public function destroy($id)
	{
		$user = $this->getUserFromScope();

		$valid = false;

		foreach($user->recipients as $recipient)
		{
			if($recipient->id == $id){
				$valid = true;
				break;
			}
		}

		if($valid)
			$user->recipients()->detach($id);
		else
			throw new OperationNotPermitedException("You can't remove this recipient");

		return Response::make(null, 204);
	}

}