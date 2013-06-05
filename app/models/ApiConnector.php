<?php


class ApiConnector{

    protected $version = 'v1';
    protected $response;

    public function dispatchRequest($request)
    {
        $originalInput = Request::input();
        Request::replace($request->input());
        $response = Route::dispatch($request);
        Request::replace($originalInput);

        $this->response = $response;

        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getBody()
    {
        return $this->response->getContent();
    }

}