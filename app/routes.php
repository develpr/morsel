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

Route::get('/', 'Morsel\AppController@home');
Route::get('/messages/{id}/info', 'Morsel\MessageController@show');


//A simple test
Route::get('/decode', function()
{

	$inputs = array(










	);
	
	foreach($inputs as $input)
	{
		$decoder = new Morsel\Decoder();

		$decoder->setRawInput($input);
		$output = $decoder->decode();
		var_dump($output);
	}

	die();
	//$decoder->decode()

});

//A simple test
Route::get('/decode/{id}', function($id)
{

	$inputs = array(
		'a0b291a1b300a0b93a1b341a0b223',
		'a0b282a1b269a0b118a1b291a0b266a1b383a0b118a1b512a0b118a1b147a0b108a1b137a0b105a1b241a0b353a1b490a0b93a1b140a0b115a1b439a0b330a1b314a0b107',
		'a0b309a1b249a0b114a1b345a0b258a1b721a0b107a1b634a0b117a1b195a0b103a1b216a0b77a1b379a0b292a1b862a0b97a1b219a0b104a1b823a0b273a1b304a0b109',
		'a0b344a1b165a0b126a1b203a0b356a1b568a0b124a1b726a0b131a1b136a0b131a1b141a0b101a1b246a0b375a1b587a0b94a1b128a0b111a1b454a0b372a1b315a0b66',
		'a0b299a1b208a0b122a1b255a0b276a1b632a0b135a1b598a0b117a1b140a0b145a1b119a0b142a1b228a0b268a1b717a0b151a1b153a0b153a1b711a0b259a1b322a0b169',
		'a0b297a1b224a0b146a1b191a0b332a1b517a0b156a1b571a0b133a1b137a0b146a1b95a0b153a1b195a0b371a1b576a0b149a1b97a0b163a1b468a0b312a1b297a0b176',
		'a0b291a1b300a0b93a1b341a0b223a1b800a0b291a1b300a0b93a1b341a0b223',
		'a0b331a1b302a0b137a1b326a0b290a1b1147a0b250a1b305a0b121a1b324a0b278a1b1530a0b230a1b365a0b121a1b335a0b363a1b0a0b4a1b1080a0b245a1b333a0b109a1b306a0b309',
		'b917a0b1069a1b902a0b1193a1b881a0b1121a1b893a0b1076a1b893a0b1059a1b876a0b1206',
		'a0b951a1b861a0b1053a1b821a0b1016a1b937a0b968a1b966a0b1119a1b1082a0b1040a1b800a0b1017a1b801a0b1212a1b855a0b1367a1b754a0b1215a1b779a0b1072a1b835a0b1118a1b812a0b1162'		
	);
		
	$decoder = new Morsel\Decoder();

	$decoder->setRawInput($inputs[$id]);
	$output = $decoder->decode();
	var_dump($output);
	
	die();
	//$decoder->decode()

});


//A simple test
Route::get('/decode/{id}/downs', function($id)
{

	$inputs = array(
		'a0b291a1b300a0b93a1b341a0b223',
		'a0b282a1b269a0b118a1b291a0b266a1b383a0b118a1b512a0b118a1b147a0b108a1b137a0b105a1b241a0b353a1b490a0b93a1b140a0b115a1b439a0b330a1b314a0b107',
		'a0b309a1b249a0b114a1b345a0b258a1b721a0b107a1b634a0b117a1b195a0b103a1b216a0b77a1b379a0b292a1b862a0b97a1b219a0b104a1b823a0b273a1b304a0b109',
		'a0b344a1b165a0b126a1b203a0b356a1b568a0b124a1b726a0b131a1b136a0b131a1b141a0b101a1b246a0b375a1b587a0b94a1b128a0b111a1b454a0b372a1b315a0b66',
		'a0b299a1b208a0b122a1b255a0b276a1b632a0b135a1b598a0b117a1b140a0b145a1b119a0b142a1b228a0b268a1b717a0b151a1b153a0b153a1b711a0b259a1b322a0b169',
		'a0b297a1b224a0b146a1b191a0b332a1b517a0b156a1b571a0b133a1b137a0b146a1b95a0b153a1b195a0b371a1b576a0b149a1b97a0b163a1b468a0b312a1b297a0b176',
		'a0b291a1b300a0b93a1b341a0b223a1b800a0b291a1b300a0b93a1b341a0b223',
		'a0b331a1b302a0b137a1b326a0b290a1b1147a0b250a1b305a0b121a1b324a0b278a1b1530a0b230a1b365a0b121a1b335a0b363a1b0a0b4a1b1080a0b245a1b333a0b109a1b306a0b309',
		'b917a0b1069a1b902a0b1193a1b881a0b1121a1b893a0b1076a1b893a0b1059a1b876a0b1206',
		'a0b951a1b861a0b1053a1b821a0b1016a1b937a0b968a1b966a0b1119a1b1082a0b1040a1b800a0b1017a1b801a0b1212a1b855a0b1367a1b754a0b1215a1b779a0b1072a1b835a0b1118a1b812a0b1162'
	);

	$decoder = new Morsel\Decoder();

	$decoder->setRawInput($inputs[$id]);
	$decoder->decode();

	$downs = $decoder->getDownTimes();

	foreach($downs as $down)
		echo $down['time'] . "<br />";

	die();
	//$decoder->decode()

});

//A simple test
Route::get('/decode/{id}/pauses', function($id)
{

	$inputs = array(
		'a0b291a1b300a0b93a1b341a0b223',
		'a0b282a1b269a0b118a1b291a0b266a1b383a0b118a1b512a0b118a1b147a0b108a1b137a0b105a1b241a0b353a1b490a0b93a1b140a0b115a1b439a0b330a1b314a0b107',
		'a0b309a1b249a0b114a1b345a0b258a1b721a0b107a1b634a0b117a1b195a0b103a1b216a0b77a1b379a0b292a1b862a0b97a1b219a0b104a1b823a0b273a1b304a0b109',
		'a0b344a1b165a0b126a1b203a0b356a1b568a0b124a1b726a0b131a1b136a0b131a1b141a0b101a1b246a0b375a1b587a0b94a1b128a0b111a1b454a0b372a1b315a0b66',
		'a0b299a1b208a0b122a1b255a0b276a1b632a0b135a1b598a0b117a1b140a0b145a1b119a0b142a1b228a0b268a1b717a0b151a1b153a0b153a1b711a0b259a1b322a0b169',
		'a0b297a1b224a0b146a1b191a0b332a1b517a0b156a1b571a0b133a1b137a0b146a1b95a0b153a1b195a0b371a1b576a0b149a1b97a0b163a1b468a0b312a1b297a0b176',
		'a0b291a1b300a0b93a1b341a0b223a1b800a0b291a1b300a0b93a1b341a0b223',
		'a0b331a1b302a0b137a1b326a0b290a1b1147a0b250a1b305a0b121a1b324a0b278a1b1530a0b230a1b365a0b121a1b335a0b363a1b0a0b4a1b1080a0b245a1b333a0b109a1b306a0b309',
		'b917a0b1069a1b902a0b1193a1b881a0b1121a1b893a0b1076a1b893a0b1059a1b876a0b1206',
		'a0b951a1b861a0b1053a1b821a0b1016a1b937a0b968a1b966a0b1119a1b1082a0b1040a1b800a0b1017a1b801a0b1212a1b855a0b1367a1b754a0b1215a1b779a0b1072a1b835a0b1118a1b812a0b1162'
	);

	$decoder = new Morsel\Decoder();

	$decoder->setRawInput($inputs[$id]);
	$decoder->decode();

	$ups = $decoder->getUpTimes();

	foreach($ups as $up)
		echo $up['time'] . "<br />";

	die();
	//$decoder->decode()

});