<?php

namespace Morsel;
use \Request;
use \Route;
use \View;
use \Redirect;
use \Auth;
use \Input;

class TransmissionController extends \BaseController {

    protected $api;
    protected $layout = 'layouts.master';


    public function __construct()
    {
        $this->api = new \ApiConnector();
    }

    public function index()
    {
        /** @var \Illuminate\Http\Request $request */
        $request = Request::create('/api/v1/transmissions?limit=20&order=desc', 'GET');
        $this->api->dispatchRequest($request);

        $transmissions = json_decode($this->api->getBody());

        $viewData = array(
            'transmissions' => $transmissions
        );

        $this->layout->content = View::make('transmissions.index')->with($viewData);
    }

}