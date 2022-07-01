<?php

namespace Httpful\Response;

use Httpful\Exeption\JsonDecodeExeption;

class Response {

    private $response;
    private $header;

    public function __construct($response, $header = [])
    {
        $this->response = $response;
        $this->header = $header;
    }

    public function getBody()
    {
        if(strpos(strtolower(implode(', ', $this->getHeader())), 'application/json') !== false){
            $result = json_decode($this->response, true);
        }
        if(json_last_error() === JSON_ERROR_NONE){
            return $result;
        } else {
            throw new JsonDecodeExeption('Error Decoding JSON:'.json_last_error());
        }
        return $this->response;
    }

    public function getHeader(){
        return $this->header;
    }
}