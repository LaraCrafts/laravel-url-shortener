<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/1.1 200 OK
Server: nginx
Content-Type: application/json
Transfer-Encoding: chunked
X-Powered-By: PHP/5.6.37-0+deb8u1
Set-Cookie: PHPSESSID=u50974qaql71l37fn2edji7340; expires=Sun, 09-Jun-2019 22:42:32 GMT; Max-Age=3600; path=/; domain=.shorte.st; HttpOnly
Access-Control-Allow-Origin: *
Cache-Control: no-cache
Date: Sun, 09 Jun 2019 21:42:32 GMT
Set-Cookie: hl=en; expires=Mon, 08-Jun-2020 21:42:32 GMT; Max-Age=31536000; path=/
Set-Cookie: cookies-enable=1; path=/; httponly
X-Server-ID: shn07
X-UA-Compatible: IE=Edge

{"status":"ok","shortenedUrl":"http:\/\/ceesty.com\/w1D1ji"}
'));
