<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(ltrim('
HTTP/1.1 400 Bad Request
Server: nginx
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
X-Powered-By: PHP/5.6.37-0+deb8u1
Set-Cookie: PHPSESSID=h9av5fl0ngpbqnvkfe0f91os61; expires=Sun, 09-Jun-2019 22:46:01 GMT; Max-Age=3600; path=/; domain=.shorte.st; HttpOnly
Cache-Control: no-cache
Date: Sun, 09 Jun 2019 21:46:01 GMT
Set-Cookie: cookies-enable=1; path=/; httponly
X-Server-ID: shn06
X-UA-Compatible: IE=Edge


'));
