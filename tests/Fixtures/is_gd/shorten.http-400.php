<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/2 400
date: Sat, 01 Jun 2019 07:06:24 GMT
content-type: text/html; charset=UTF-8
set-cookie: __cfduid=d8ddac9f1ceba2876dd2407d383fae8af1559372784; expires=Sun, 31-May-20 07:06:24 GMT; path=/; domain=.is.gd; HttpOnly; Secure
expect-ct: max-age=604800, report-uri="https://report-uri.cloudflare.com/cdn-cgi/beacon/expect-ct"
server: cloudflare
cf-ray: 4dff583d2f3fc76d-AMS

Error: Please specify a URL to shorten.
'));
