<?php

use function GuzzleHttp\Psr7\parse_response;

return parse_response(trim('
HTTP/2 200 
date: Sat, 15 Jun 2019 11:42:59 GMT
content-type: text/html; charset=UTF-8
set-cookie: __cfduid=d42d736f9ab5f6d72dbd1cdcd507ccda81560598978; expires=Sun, 14-Jun-20 11:42:58 GMT; path=/; domain=.ouo.io; HttpOnly; Secure
cache-control: no-cache
set-cookie: ouoio_session=eyJpdiI6IkhkTVNZXC94aTNRXC9uSXAwSCtEMmFcL1g4UzBKNXN2cndDVXNwTVVHaEZoWGM9IiwidmFsdWUiOiJqOWszc2MxOEREd2lvZlwvMDJDU1UzcGZwVVZocDJwWFVydXdJbGxYNjl2aEMzY2xZWjVcL05sV2t3R1A5MklwREh1QXQzVWFyMkdnSGpEOWllZWV0VTlRPT0iLCJtYWMiOiIxOWVhZTFhZjdlZDJmYzA2NzRhNTRmMTcxMzBkYzIwNDY3NzAyM2E3MzAzNTEzYmUyOWZjNDNjM2YzMjZjYWMxIn0%3D; expires=Sat, 15-Jun-2019 13:29:59 GMT; Max-Age=7200; path=/; httponly
set-cookie: language=eyJpdiI6IjBZOWVCYzB2TEdIT3BxcEVRXC9EcmQ3QnlvMEY4TXdSdjFvRXJEckVTNGdzPSIsInZhbHVlIjoibTdHVEFkYmdhUGpLVitBbHdQZ1FsdHBjcTl1TTkyTDRZYXNnZFoxQ21uTT0iLCJtYWMiOiJkYzJiNThjNmYyZTY2MWIxNDBlMjZlOTMzNWI1OTZiMzc2YzE3OTc0ZjBiMzI0YTk0N2YzNzE1OWI5ZDUyMzJkIn0%3D; expires=Thu, 13-Jun-2024 11:29:59 GMT; Max-Age=157680000; path=/; httponly
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
x-xss-protection: 1; mode=block
expect-ct: max-age=604800, report-uri="https://report-uri.cloudflare.com/cdn-cgi/beacon/expect-ct"
server: cloudflare
cf-ray: 4e7448a279d19f1b-AMS

https://ouo.io/lpfqW3o
'));
