<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/2 200 
date: Sat, 01 Jun 2019 06:40:07 GMT
content-type: text/html; charset=UTF-8
set-cookie: __cfduid=d0cf4961cf498445e99cd9a4d9564f3291559371207; expires=Sun, 31-May-20 06:40:07 GMT; path=/; domain=.is.gd; HttpOnly; Secure
expect-ct: max-age=604800, report-uri=\'https://report-uri.cloudflare.com/cdn-cgi/beacon/expect-ct\'
server: cloudflare
cf-ray: 4dff31bc2b35d8f5-AMS

https://is.gd/jAxBiv
'));
