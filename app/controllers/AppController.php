<?php

namespace Morsel;
use \Request;
use \Route;
use \View;
use \Redirect;
use \Auth;
use \Input;

class AppController extends \BaseController {

    protected $api;
    protected $layout = 'layouts.master';


    public function __construct()
    {
        $this->api = new \ApiConnector();
    }


    public function home()
    {
        $this->layout->content = View::make('home');
    }



}