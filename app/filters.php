<?php

use \Symfony\Component\Finder\Exception\AccessDeniedException;

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('account');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});


/**
 * 		Check to see if a user has the permissions to view a particular message
 */
Route::filter('auth.message', function(Illuminate\Routing\Route $route)
{
	//We need to:
	//	1) created by the user or
	//	2) in the user's transmission queue

	//User needs to be logged in for sure to be able to view any messages, so check that first
	//Note that the user should be "virtually" signed in if it's a API request authenticated via hmac
	if(Auth::check())
	{
		$user = Auth::user();

		$messageId = $route->getParameter('messages');

		$message = Morsel\Message::find($messageId);

		//If this message doesn't exist, we'll let the API deal with this!
		if(!$message)
			return null;

		else if($message->user->id == $user->id)
			return null;

		else
		{
			//Else we need to go through the trouble of figuring out whether or not a transmission exists with this user
			$transmission = Morsel\Transmission::where('message_id', $messageId)->first();

			if(isset($transmission) && $transmission->receiver->id == $user->id)
				return null;
		}

	}

	//We made it this far... which is not good for our adventurer
	throw new AccessDeniedException('Access not found');

});

/**
 * 		Check to see if a user has the permissions to view a particular transmission
 */
Route::filter('auth.transmission', function(Illuminate\Routing\Route $route)
{
    //We need to:
    //	1) see if the user requesting this transmission is either the sender or the receiver of said transmission

    //User needs to be logged in for sure to be able to view any messages, so check that first
    //Note that the user should be "virtually" signed in if it's a API request authenticated via hmac
    if(Auth::check())
    {
        $user = Auth::user();

        $transmissionId = $route->getParameter('transmissions');

        $transmission = Morsel\Transmission::find($transmissionId);

        //If this message doesn't exist, we'll let the API deal with this!
        if(!$transmission)
            return null;

        else if($transmission->receiver->id == $user->id || $transmission->sender->id == $user->id)
            return null;
    }

    //We made it this far... which is not good for our adventurer
    throw new AccessDeniedException('Access not found');

});



Route::filter('auth.hmac', function()
{
    //First check if there is a user that is actually logged in
    if(Auth::check())
        return null;

    $uri = Request::fullUrl();
    $entityBody = Request::getContent();

    $signatureIngredients = $uri . $entityBody;

    $authHeader = Request::header('Auth');

	if(!$authHeader)
		throw new AccessDeniedException('Authentication failure. An invalid Auth header was provided.');

	$authHeader = explode(':',$authHeader);

	if(sizeof($authHeader) != 2)
		throw new AccessDeniedException('Authentication failure. An invalid Auth header was provided.');

	$userId = $authHeader[0];
	$requestSignature = $authHeader[1];

    if(!$userId)
        throw new AccessDeniedException('Authentication failure. No user key/id was provivded in the header. This is a requirement for use of the API (or login via the web app).');

    $key = Crypt::decrypt(User::find($userId)->secret_key);
    $computedSignature = hash_hmac('md5', $signatureIngredients, $key);

    if(!$requestSignature)
        throw new AccessDeniedException('Authentication failure. No signature was provided in the header. This is a requirement for use of the API (or login via the web app).');

    $hmacValid = $requestSignature == $computedSignature ? null : false;

    if($hmacValid !== false)
    {
        Auth::loginUsingId($userId);
        return $hmacValid;
    }
    else
    {
        throw new AccessDeniedException('You need to authenticate before you can use the API. Please be sure you are logged in or have supplied a valid/active Auth header.');
    }

});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});