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
Route::get('/', 'Morsel\AppController@home');
Route::get('/messages/{id}/info', 'Morsel\MessageController@show');

/**
 * APP MESSAGES
 */
Route::get('/messages', array('before' => 'auth',
	'uses' => 'Morsel\MessageController@index'));

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
 *              API - STORES
 */
Route::group(array('before' => 'auth.hmac'), function() {
	//Store resource
	Route::resource('/api/v1/messages', 'Morsel\Api\V1\MessageController');
});
/*
 *              API - USERS
 */
Route::resource('/api/v1/users', 'Morsel\Api\V1\UserController');
