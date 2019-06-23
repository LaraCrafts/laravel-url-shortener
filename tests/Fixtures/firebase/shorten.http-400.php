<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/1.1 400 Bad Request
Vary: X-Origin
Vary: Referer
Content-Type: application/json; charset=UTF-8
Date: Sun, 23 Jun 2019 12:20:33 GMT
Server: ESF
Cache-Control: private
X-XSS-Protection: 0
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
Alt-Svc: quic=":443"; ma=2592000; v="46,44,43,39"
Accept-Ranges: none
Vary: Origin,Accept-Encoding
Transfer-Encoding: chunked

{
  "error": {
    "code": 400,
    "message": "Link value cannot be empty [https://firebase.google.com/docs/dynamic-links/create-manually#parameters]",
    "status": "INVALID_ARGUMENT"
  }
}
'));
