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

// APP TESTING
Route::get('/', 'Morsel\HomeController@home');
Route::get('/messages/{id}/info', 'Morsel\MessageController@show');

/**
 * APP MESSAGES
 */
Route::get('/messages', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@index'));
Route::get('/messages/create', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@create'));
Route::post('/messages/create', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@store'));
Route::get('/messages/{id}', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@show'));


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
Route::group(array('before' => 'auth.hmac'), function() {
	Route::resource('/api/v1/transmissions', 'Morsel\Api\V1\TransmissionController');
});

/*
 *              API - Users
 */
Route::resource('/api/v1/users', 'Morsel\Api\V1\UserController');
