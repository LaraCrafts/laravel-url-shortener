<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/1.1 200 OK
Content-Type: application/json; charset=UTF-8
Vary: X-Origin
Vary: Referer
Date: Sun, 23 Jun 2019 12:00:06 GMT
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
  "shortLink": "https://laracrafts.page.link/NLtk",
  "previewLink": "https://laracrafts.page.link/NLtk?d=1"
}
'));
