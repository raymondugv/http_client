<?php

namespace Httpful\Httpclient;

use Httpful\Exeption\ResponseExeption;
use Httpful\Response\Response;

class HttpClient
{

    public static function send($method, $url, $body = null, $header = [])
    {
        [$url, $option] = self::createRequest($method, $url, $body, $header);

        $context = stream_context_create($option);
        $result = file_get_contents($url, false, $context);

        if ($result == false) {
            $status_line = implode(',', $http_response_header);
            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
            $status = $match[1];

            if (strpos($status, '2') !== 0 && strpos($status, '3') !== 0) {
                throw new ResponseExeption("Unexpected response status: {$status} while fetching {$url}\n" . $status_line);
            }
        }

        return new Response($result, $http_response_header);
    }

    public static function createRequest($method, $url, $body = null, $header = [])
    {
        $method = strtoupper($method);
        $header = array_change_key_case($header, CASE_LOWER);
        $content = '';
        switch ($method) {
            case 'OPTIONS':
            case 'GET':
                if (is_array($body)) {
                    if (strpos($url, '?') !== false) {
                        $url .= '&';
                    } else {
                        $url .= '?';
                    }

                    $url .= urldecode(http_build_query($body));
                }
                break;
            case 'DELETE':
            case 'PUT':
            case 'POST':
                if (is_array($body)) {
                    if (!empty($header['content-type'])) {
                        switch (trim($header['content-type'])) {
                            case 'application/x-www-form-urlencoded':
                                $body = http_build_query($body);
                                break;
                            case 'application/json':
                                $body = json_encode($body);
                                break;
                        }
                    } else {
                        $header['content-type'] = 'application/x-www-form-urlencoded';
                        $body = http_build_query($body);
                    }
                } elseif (empty($header['content-type'])) {
                    $header['content-type'] = 'application/x-www-form-urlencoded';
                }

                $content = $body;
                break;
        }

        $option = [
            'http' => [
                'method' => $method,
            ],
        ];

        if ($header) {
            $option['http']['header'] = implode("\r\n",
                array_map(function ($value, $key) {
                    return sprintf("%s: %s", $key, $value);
                }, $header, array_keys($header)));
        }

        if ($content) {
            $option['http']['content'] = $content;
        }

        return [$url, $option];
    }
}
