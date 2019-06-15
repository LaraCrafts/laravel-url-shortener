<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/2 400 
date: Sun, 09 Jun 2019 21:19:17 GMT
content-type: text/plain;charset=UTF-8
content-length: 5
set-cookie: __cfduid=def5578458366720fe31b2319fd7f66691560115156; expires=Mon, 08-Jun-20 21:19:16 GMT; path=/; domain=.tinyurl.com; HttpOnly
cache-control: max-age=7200
expect-ct: max-age=604800, report-uri="https://report-uri.cloudflare.com/cdn-cgi/beacon/expect-ct"
server: cloudflare
cf-ray: 4e462491e956d901-AMS

Error
'));
