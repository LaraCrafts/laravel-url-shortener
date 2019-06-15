<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/1.1 403 Forbidden
Server: nginx
Date: Sat, 15 Jun 2019 11:55:09 GMT
Content-Type: application/json
Content-Length: 23
Connection: keep-alive
Strict-Transport-Security: max-age=31536000; includeSubDomains
X-XSS-Protection: 1; mode=blockFilter
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
Content-Security-Policy: default-src \'none

{"message":"FORBIDDEN"}
'));
