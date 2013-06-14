<?php

namespace Morsel\Api\V1;
use \Input;
use \Response;
use \Auth;
use \DB;
use Morsel\Message;
use Morsel\Transmission;

class TransmissionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        //
        $limit = 1;
        $skip = 0;

        if(Input::has('limit'))
            $limit = Input::get('limit');

        if(Input::has('skip'))
            $skip = Input::get('skip');

        if(Input::has('direction') && strtolower(Input::get('direction')) == 'sent')
        {
            $query = Transmission::where('sender_id', Auth::user()->id);
        }
        else if(Input::has('direction') && strtolower(Input::get('direction')) == 'received')
        {
            $query = Transmission::where('receiver_id', Auth::user()->id);
        }
        else
        {
            $query = Transmission::where('receiver_id', Auth::user()->id)->
                orWhere('sender_id', Auth::user()->id);
        }

        if(Input::has('received'))
            $query->where('received', Input::get('received'));

        $transmissions = $query->orderBy('created_at', 'desc')->skip($skip)->take($limit)->with("Message")->get();

        return Response::json($transmissions, 200);

    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $transmission = Transmission::find($id)->with("Message");

        return Response::json($transmission, 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        $transmission = Transmission::find($id);
		//update the transmission
        if(Input::has('received') and Input::get('received') == true)
        {
            $transmission->received = true;
            $transmission->save();
            return Response::make(null, 204);
        }

        return Response::make(null, 304);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//destroy the transmission
        $transmission = Transmission::find($id);

        $transmission->delete();

        return Response::make(null, 204);
	}

}