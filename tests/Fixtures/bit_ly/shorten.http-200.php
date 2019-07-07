<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/1.1 200 OK
Server: nginx
Date: Sat, 15 Jun 2019 12:04:01 GMT
Content-Type: application/json
Content-Length: 263
Connection: keep-alive
Strict-Transport-Security: max-age=31536000; includeSubDomains
X-XSS-Protection: 1; mode=blockFilter
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
Content-Security-Policy: default-src \'none

{"created_at":"1970-01-01T00:00:00+0000","id":"bit.ly/2WujBe0","link":"http://bit.ly/2WujBe0","custom_bitlinks":[],"long_url":"https://google.com/","archived":false,"tags":[],"deeplinks":[],"references":{"group":"https://api-ssl.bitly.com/v4/groups/Bj1tjw4uLSN"}}
'));
