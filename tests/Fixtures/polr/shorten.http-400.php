<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/1.1 400 Bad Request
Date: Fri, 07 Jun 2019 20:09:35 GMT
Content-Type: text/plain;charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
Set-Cookie: __cfduid=d1b584c6da86f8ac69e8adf86f419452e1559938174; expires=Sat, 06-Jun-20 20:09:34 GMT; path=/; domain=.polr.me; HttpOnly
X-Powered-By: PHP/7.1.6
Cache-Control: no-cache
Access-Control-Allow-Origin: *
Server: cloudflare
CF-RAY: 4e3543b93c08d915-AMS

400 Invalid or missing parameters.
'));
