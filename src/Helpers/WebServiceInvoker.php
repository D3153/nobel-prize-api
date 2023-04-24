<?php

use GuzzleHttp\Client;

class WebServiceInvoker
{
    private bool $is_success = false;
    private $request_options = [];

    public function __construct(array $options = []) {
        $this->request_options = $options;
    }

    public function invokeUri(string $resource_uri)
    {
        // -- Client Implementation
        // 1. Sending a request: instanciate a client object
        $client = new GuzzleHttp\Client();
        $response = $client->request('GET', $resource_uri, $this->request_options);
        // 2. We need to process a response
        // check status
        if($response->getStatusCode() != 200){
            $this->is_success  = true; 
            throw new Exception('Something went wrong!' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
        }
        // verify the requested resource representation
        // is it something the client/code can parse
        if(!str_contains($response->getHeaderLine('Content-Type'), 'application/json')){
            throw new Exception('Unprocessable document: JSON type required: ' . $response->getReasonPhrase());
        }
        // 3. now we retrieve the data from response body
        $data = $response->getBody()->getContents();
        return $data;
    }
    public function is_sucessful()
    {
        return $this->is_success;
    }
}
