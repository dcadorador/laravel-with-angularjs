<?php

namespace App\Services;

use Exception;

class ClickBankService
{
    /**
     * Methods GET, PUT, POST, DELETE
     */
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_GET = 'GET';
    const METHOD_DELETE = 'DELETE';

    /**
     * @params
     *      $dev_key - CB dev key
     *      $clerk_key - CB clerk key
     *      $secret - CB secret key
     *      $errors - var that will hold any error
     *      $http_code - HTTP code resutned by the request
     *      $url - CB url
     *      $headers - curl request headers
     */
    private $dev_key;
    private $clerk_key;
    private $secret;
    protected $errors = null;
    protected $cb_error_400 = null;
    protected $http_code = 200;
    private $url = "https://api.clickbank.com/rest/1.3/";
    private $headers = [
        'Accept' => 'Accept: application/json'
    ];

    /**
     * Initialize keys
     */
    public function __construct($dev_key, $clerk_key, $secret)
    {
        $this->dev_key = $dev_key;
        $this->clerk_key = $clerk_key;
        $this->secret = $secret;
        $this->setHeader('Authorization',"$this->dev_key:$clerk_key");
    }

    /**
     * Set Header
     *
     * @param
     *      $key - the header key
     *      $value - header value
     */
    public function setHeader($key, $value) {
        $this->headers[$key] = $value ? "{$key}: {$value}" : $value;
    }

    /**
     * Http Code Getter
     *
     * @return
     *      http code of the request
     */
    public function getHttpCode() {
        return $this->http_code;
    }

    /**
     * Returns errors
     *
     * @return
     *      array of errors
     */
    public function getCBErrors(){
        return $this->cb_error_400;
    }

    /**
     * @param
     *      $method - http method
     *      $service - api service
     *      $data - array data for the api request
     * @return
     *      $json - returns the json response of the api call
     */
    private function request( $method, $service, array $data = [] )
    {
        $curl = curl_init();
        //dd($this->url . $service);
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url . $service,
            CURLOPT_HEADER => 1,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HEADER => 1,
            CURLINFO_HEADER_OUT => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
        ]);

        switch ($method) {
            case 'PUT':
            case 'PATCH':
            case 'POST':
                curl_setopt_array($curl, [
                    CURLOPT_CUSTOMREQUEST => $method
                ]);
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                break;
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, array_filter(array_values($this->headers)));

        $response = curl_exec($curl);

        $this->http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if(curl_error($curl)){
            $this->errors = curl_error($curl);
        }

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        curl_close($curl);

        if(isset($this->errors)){
            throw new Exception($this->errors,$this->http_code);
        }

        $json = json_decode(substr($response, $header_size), false, 512, JSON_BIGINT_AS_STRING);

        if($json === null) {
            $this->cb_error_400 = substr($response, $header_size);
        }

        return $json;
    }

    /**
     * GET
     * @param
     *      $service - api service
     */
    public function get($service)
    {
        return $this->request(self::METHOD_GET, $service);
    }

    /**
     * POST
     * @param
     *      $service - api service
     *      $data - array of data for the service
     */
    public function post($service, $data = [])
    {
        $service .= '?';
        foreach ($data as $key => $value) {
            $service .= "$key=$value".'&';
        }
        $url = rtrim($service,'&');
        //\Log::info('CB POST Request URI: '.$url);
        return $this->request(self::METHOD_POST, $url);
    }

    /**
     * PUT
     * @param
     *      $service - api service
     *      $data - array of data for the service
     */
    public function put($service, $data = [])
    {
        return $this->request(self::METHOD_PUT, $service, $data);
    }


    /**
     * DELETE
     * @param
     *      $service - api service
     *      $data - array of data for the service
     */
    public function delete($service, $data = [])
    {
        return $this->request(self::METHOD_DELETE, $service, $data);
    }
}