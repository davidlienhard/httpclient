# davidlienhard/httpclient
🐘 php library to send http requests

[![Latest Stable Version](https://img.shields.io/packagist/v/davidlienhard/httpclient.svg?style=flat-square)](https://packagist.org/packages/davidlienhard/httpclient)
[![Source Code](https://img.shields.io/badge/source-davidlienhard/httpclient-blue.svg?style=flat-square)](https://github.com/davidlienhard/httpclient)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/davidlienhard/httpclient/blob/master/LICENSE)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%208.0-8892BF.svg?style=flat-square)](https://php.net/)
[![CI Status](https://github.com/davidlienhard/smeraldoPricebox/actions/workflows/check.yml/badge.svg)](https://github.com/davidlienhard/smeraldoPricebox/actions/workflows/check.yml)

## Setup

You can install through `composer` with:

```
composer require davidlienhard/httpclient
```

*Note: davidlienhard/httpclient requires PHP 8.0*

## Examples

### Simple Example
```php
<?php
use DavidLienhard\HttpClient\Client;

$http = new Client;
$response = $http->get("https://test.com/");

echo $response->getStatusCode() === 200
    ? "request was successful";
    : "request failed";
```

### Do not verify SSL Cert
```php
<?php
use DavidLienhard\HttpClient\Client;
use DavidLienhard\HttpClient\Request;

$request = (new Request)->verifySslPeer(false);
$http = new Client($request);
$response = $http->get("https://test.com/");

echo $response->getStatusCode() === 200
    ? "request was successful";
    : "request failed";
```

### Add Cookies
```php
<?php
use DavidLienhard\HttpClient\Client;
use DavidLienhard\HttpClient\Cookie;
use DavidLienhard\HttpClient\CookieJar;
use DavidLienhard\HttpClient\Request;

$cookiejar = new CookieJar(
    new Cookie("name1", "value1"),
    new Cookie("name2", "value2")
);
$http = new Client(cookiejar: $cookiejar);
$response = $http->get("https://test.com/");

echo $response->getStatusCode() === 200
    ? "request was successful";
    : "request failed";
```

## License

The MIT License (MIT). Please see [LICENSE](https://github.com/thephpleague/oauth2-client/blob/master/LICENSE) for more information.
