<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/ok', function(){
	$api = new \ApiConnector();
	$input = array('text' => 'blah');
	$request = Request::create('/api/v1/messages', 'POST', $input);
	$api->dispatchRequest($request);
});

Route::get('/blah', function(){
	$user = User::find(2);
	$user->recipients()->attach(1);
});

Route::get('/lol', function(){
	$user = User::find(2);

	$test = $user->recipients()->where('');
	var_dump($test);
});

Route::get('/relationships', 'Morsel\UserController@relationships');

// APP TESTING
Route::get('/', 'Morsel\HomeController@home');
Route::get('/messages/{id}/info', 'Morsel\MessageController@show');

/**
 * APP MESSAGES
 */
//Route::get('/messages', array('before' => 'auth',
//	'uses' => 'Morsel\MessageController@index'));
Route::get('/messages/create', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@create'));
Route::get('/messages/create-hard-mode', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@createHard'));
Route::post('/messages/create', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@store'));
Route::get('/messages/{id}', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@show'));

/**
 * APP MESSAGES
 */
Route::get('/transmissions', array('before' => 'auth',
    'uses' => 'Morsel\TransmissionController@index'));


/**
 * APP USERS
 */
Route::get('/my-account', array('before' => 'auth',
	'uses' => 'Morsel\UserController@editBasics'));

Route::get('/my-account', array('before' => 'auth',
	'uses' => 'Morsel\UserController@editBasicsView'));

Route::put('/my-account', array('before' => 'auth',
	'uses' => 'Morsel\UserController@editBasicsPost'));
Route::get('/account', 'Morsel\UserController@account');
Route::post('/account/login', 'Morsel\UserController@login');
Route::post('/account/register', 'Morsel\UserController@register');
Route::get('/logout', function(){
	Auth::logout();
	return Redirect::to('/');
});

Route::get('/login', function(){
    return Redirect::to('/account');
});


/*
 * ====================
 * -----------------------------------------------------
 *              API - V1
 * -----------------------------------------------------
 * ====================
 */

/*
 *              API - Messages
 */
Route::group(array('before' => 'auth.hmac'), function() {
	Route::resource('/api/v1/messages', 'Morsel\Api\V1\MessageController');
});

/*
 *              API - Transmissions
 */
Route::group(array('before' => 'auth.hmac|auth.transmission'), function() {
	Route::resource('/api/v1/transmissions', 'Morsel\Api\V1\TransmissionController');
});

/*
 *              API - Users
 */
Route::resource('/api/v1/users', 'Morsel\Api\V1\UserController');

/*
 *				API - Recipients
 */
Route::group(array('before' => 'auth.hmac'), function() {
	Route::resource('/api/v1/recipients', 'Morsel\Api\V1\RecipientController');
});

/*
 *				API - Senders
 */
Route::group(array('before' => 'auth.hmac'), function() {
	Route::resource('/api/v1/senders', 'Morsel\Api\V1\SenderController');
});
