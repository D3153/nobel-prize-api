<?php
namespace Vanier\Api\Helpers;
use Exception;
use GuzzleHttp\Client;

/**
 * WebServiceInvoker
 */
class WebServiceInvoker
{
    /**
     * is_success
     * @var bool
     */
    private bool $is_success = false;
    /**
     * request_options
     * @var array
     */
    private $request_options = [];

    /**
     * __construct
     * @param array $options
     */
    public function __construct(array $options = []) {
        $this->request_options = $options;
    }

    /**
     * invokeUri
     * acts as a client to get request
     * @param string $resource_uri
     * @throws Exception
     * @return string
     */
    public function invokeUri(string $resource_uri)
    {
        // -- Client Implementation
        // 1. Sending a request: instantiate a client object
        $client = new Client();
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
    /**
     * is_sucessful
     * @return bool
     */
    // public function is_sucessful()
    // {
    //     return $this->is_success;
    // }
}
