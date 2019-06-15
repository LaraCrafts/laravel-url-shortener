<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/2 200 
date: Sun, 09 Jun 2019 21:20:18 GMT
content-type: text/plain;charset=UTF-8
content-length: 24
set-cookie: __cfduid=d168f41c88b2aa48a03cbae57980ee8281560115218; expires=Mon, 08-Jun-20 21:20:18 GMT; path=/; domain=.tinyurl.com; HttpOnly
cache-control: max-age=3600
expect-ct: max-age=604800, report-uri="https://report-uri.cloudflare.com/cdn-cgi/beacon/expect-ct"
server: cloudflare
cf-ray: 4e4626123d379c2d-AMS

http://tinyurl.com/mbq3m
'));
