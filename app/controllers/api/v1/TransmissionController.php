<?php

namespace Morsel\Api\V1;
use \Input;
use \Response;
use \Auth;

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

        $query = Auth::user()->receivedTransmissions()->with("Message");

        if(Input::has('received'))
            $query->where('received', Input::get('received'));


        $transmissions = $query->orderBy('created_at', 'desc')->skip($skip)->take($limit)->get();

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
		//
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}