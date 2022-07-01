<?php

namespace Httpful;

require_once 'vendor/autoload.php';
use Httpful\Httpclient\ResponseAPI;
use Httpful\RequestAPI;

function getRequest()
{

    $response = RequestAPI::get('https://postman-echo.com/get');
    ResponseAPI::dumpResponse($response);
}

function postRequest()
{

    $response = RequestAPI::post('https://postman-echo.com/post', 'Any Thing');
    ResponseAPI::dumpResponse($response);

}

function postRequestWithJson()
{
    $response = RequestAPI::post(
        'https://postman-echo.com/post',
        ['test' => 'value', 'test2' => 'value2'],
        ['content-type' => 'application/json']
    );
    ResponseAPI::dumpResponse($response);
}

function sendAssessment()
{
    $tokenResponse = RequestAPI::options('https://corednacom.corewebdna.com/assessment-endpoint.php');

    $response = RequestAPI::post(
        'https://corednacom.corewebdna.com/assessment-endpoint.php',
        [
            'name' => 'Hoanh Le Kien',
            'email' => 'lkhoanh@cmcglobal.vn',
            'url' => 'https://github.com/raymondugv/http_client',
        ],
        [
            'Authorization' => 'Bearer ' . $tokenResponse->getBody(),
            'content-type' => 'application/json',
        ]
    );

    ResponseAPI::dumpResponse($response);
}

//getRequest();
//postRequest();
postRequestWithJson();
// sendAssessment();
