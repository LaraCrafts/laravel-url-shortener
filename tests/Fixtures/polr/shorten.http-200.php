<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/1.1 200 OK
Date: Fri, 07 Jun 2019 20:19:33 GMT
Content-Type: application/json
Transfer-Encoding: chunked
Connection: keep-alive
Set-Cookie: __cfduid=d74a3fd364bebf9c3a34a19897547d70b1559938773; expires=Sat, 06-Jun-20 20:19:33 GMT; path=/; domain=.polr.me; HttpOnly
X-Powered-By: PHP/7.1.6
Cache-Control: no-cache
Access-Control-Allow-Origin: *
Set-Cookie: laravel_session=eyJpdiI6Impkb2NvdFozZHlzMVlEMU85TmVmblE9PSIsInZhbHVlIjoiMVRpUWZ6dVBjbW1JYlIwazJ1YXY5OHlKZ0pBVFwvRGY2VVBxUmtTMnNVeHVcL1VEbXdybEgrWllndnFRMis1c3dVVEY4blk0cWVLUFFOXC92eFROOHZrWmc9PSIsIm1hYyI6IjE0ZTc0ZDUxZThjNDg3Mzk0YzhiYWQzNjA4MzFmZDc0N2ExNDBjZWQzNTI2MGI1MjIwZmUxNzYzMTllZjNjM2UifQ%3D%3D; expires=Fri, 07-Jun-2019 22:19:33 GMT; Max-Age=7200; path=/; HttpOnly
Server: cloudflare
CF-RAY: 4e355253fbd9d8c9-AMS

{"action":"shorten","result":"http:\/\/demo.polr.me\/0"}
'));
