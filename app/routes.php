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

Route::get('/', function()
{
	return View::make('hello');
});

//A simple test
Route::get('/decode/{id}', function($id)
{

	$input1 = 'a0b291a1b300a0b93a1b341a0b223';
	//hash: 93b885adfe0da089cdf634904fd59f71

	$input2 = 'a0b282a1b269a0b118a1b291a0b266a1b383a0b118a1b512a0b118a1b147a0b108a1b137a0b105a1b241a0b353a1b490a0b93a1b140a0b115a1b439a0b330a1b314a0b107';
	//hash: 93b885adfe0da089cdf634904fd59f71


 	$choice = 'input' . $id;

	$input = $$choice;

	$decoder = new Morsel\Decoder();

	$decoder->setRawInput($input);

	$output = $decoder->processRawInput();

	die($output);

	//$decoder->decode()

});