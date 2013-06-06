<?php

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
	if (Auth::guest()) return Redirect::guest('login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('auth.message', function()
{
	if(!Auth::check())
		throw new AccessDeniedException('Access not found');
});


Route::filter('auth.hmac', function()
{
    //First check if there is a user that is actually logged in
    if(Auth::check())
        return null;

    $body = file_get_contents('php://input');
    $authHeader = Request::header('AUTHORIZATION');
	$authHeader = split(':',$authHeader);

	$userId = $authHeader[0];
	$signature = $authHeader[1];

    if(!$userId)
        throw new AccessDeniedException('Authentication failure. No PROVISIONER-KEY was provivded in the header. This is a requirement for use of the API (or login via the web app).');

    //todo: security - HMAC?
//    $key = User::find($userId)->secretkey;
//    $serverHmac = hash_hmac('sha1', $body, $key);


    if(!$signature)
        throw new AccessDeniedException('Authentication failure. No PROVISIONER-HMAC was provivded in the header. This is a requirement for use of the API (or login via the web app).');

    //$hmacValid = $clientHmac == $serverHmac ? null : 'false';

//    if($hmacValid !== false)
//    {
//        Auth::loginUsingId($userId);
//        return $hmacValid;
//    }

    //todo: remove this - for now we just will accept any hmac/key and log the user in
    if(true)
    {
        $user = User::find($userId);
        Auth::setUser($user);

        return null;
    }
    else
    {
        throw new AccessDeniedException('You need to authenticate before you can use the API. Please be sure you are logged in or have supplied a valid/active PROVISIONER-KEY and PROVISIONER-HMAC.');
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