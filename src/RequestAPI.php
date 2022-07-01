<?php

namespace Httpful;

use Httpful\Httpclient\HttpClient;

class RequestAPI
{

    public static function get($url, $body = null, $header = [])
    {

        return HttpClient::send('GET', $url, $body, $header);
    }

    public static function post($url, $body = null, $header = [])
    {

        return HttpClient::send('POST', $url, $body, $header);
    }

    public static function put($url, $body = null, $header = [])
    {

        return HttpClient::send('PUT', $url, $body, $header);
    }

    public static function delete($url, $body = null, $header = [])
    {

        return HttpClient::send('DELETE', $url, $body, $header);
    }

    public static function options($url, $body = null, $header = [])
    {

        return HttpClient::send('OPTION', $url, $body, $header);
    }

}
