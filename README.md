# laravel-url-shortener
Powerful URL shortening tools in Laravel

<p align="center">
    <a href="https://travis-ci.org/LaraCrafts/laravel-url-shortener"><img src="https://travis-ci.org/LaraCrafts/laravel-url-shortener.svg?branch=master"></a>
    <a href="https://packagist.org/packages/laracrafts/laravel-url-shortenern"><img src="https://poser.pugx.org/laracrafts/laravel-url-shortener/downloads"></a>
    <a href="https://packagist.org/packages/laracrafts/laravel-url-shortener"><img src="https://poser.pugx.org/laracrafts/laravel-url-shortener/version"></a>
    <a href="https://scrutinizer-ci.com/g/LaraCrafts/laravel-url-shortener/"><img src="https://scrutinizer-ci.com/g/LaraCrafts/laravel-url-shortener/badges/coverage.png?b=master"></a>
    <a href="https://packagist.org/packages/laracrafts/laravel-url-shortener"><img src="https://poser.pugx.org/laracrafts/laravel-url-shortener/license"></a>
</p>

- [Installation](#installation)
    - [Requirements](#requirements)
    - [Laravel 5.5+](#laravel-55)
    - [Laravel 5.1-5.4](#laravel-51-54)
    - [Lumen](#lumen)
- [Usage](#usage)
    - [Changing the default driver](#changing-the-default-driver)
- [Available drivers](#available-drivers)
    - [Bit.ly](#bitly)
    - [Is.gd](#isgd--vgd)
    - [Shorte.st](#shortest)
    - [TinyURL](#tinyurl)
    - [V.gd](#isgd--vgd)
    
## Installation
You can easily install this package using Composer, by running the following command:

```bash
composer require laracrafts/laravel-url-shortener
```

### Requirements
This package has the following requirements:

- PHP 7.1 or higher
- Laravel (or Lumen) 5.1 or higher

### Laravel 5.5+
If you use Laravel 5.5 or higher, that's it. You can now use the package, continue to the [usage](#usage) section.

### Laravel 5.1-5.4
If you're using an older version of Laravel, register the package's service provider to your application. You can do
this by adding the following line to your `config/app.php` file:

```php
'providers' => [
   ...
   LaraCrafts\UrlShortener\UrlShortenerServiceProvider::class,
   ...
],
```

### Lumen
If you're using Lumen, register the package's service provider by adding the following line to your `bootstrap/app.php`
file:

```php
$app->register(LaraCrafts\UrlShortener\UrlShortenerServiceProvider::class);
```

## Usage
The shortener can be retrieved from the container in two ways:

```php
// This works in both Laravel and Lumen
$shortener = app('url.shortener');
// This only works in Laravel 5.2+
$shortener = url()->shortener();
```

Once you have an instance of the shortener, you can shorten your URLs:

```php
// This will return your shortened URL as a string
$shortener->shorten(...);

// This will return a promise which will resolve to your shortened URL
$shortener->shortenAsync(...);

// You can also call shortening from Laravel's url component directly
app('url')->shorten(...);

// or...
url()->shorten(...);
```

This package relies on Guzzle's promise library for its asynchronous shortening, read their
[documentation](https://github.com/guzzle/promises) for more information.

You can also use dependency injection to inject the shortener into a method:

```php
class MyController extends Controller
{
    public function myFunction(ShortenerManager $shortener)
    {
        $shortener->shorten(...);
    }
}
```

The shortener exposes the following methods:

Method         | Description
---------------|-------------------------------------
`shorten`      | Shorten the given URL
`shortenAsync` | Shorten the given URL asynchronously
`driver`       | Retrieve a driver (e.g. `tiny_url`)

### Changing the default driver
You can change the default driver by setting `URL_SHORTENER_DRIVER={driver}` in your environment file or publishing the
config file and changing it directly.

## Available drivers
Below is a list of available drivers along with their individual specs:

Service                | Driver name | Since version | Analytics | Monetization
-----------------------|-------------|---------------|-----------|-----------------
[Bit.ly](#bitly)       | `bit_ly`    | 1.0.0         | yes       | no
[Is.gd](#isgd--vgd)    | `is_gd`     | 0.2.0         | yes       | no
[Shorte.st](#shortest) | `shorte_st` | 1.0.0         | yes       | yes
[TinyURL](#tinyurl)    | `tiny_url`  | 1.0.0         | no        | no
[V.gd](#isgd--vgd)     | `is_gd`     | 0.2.0         | yes       | no

### Bit.ly
[website](https://bit.ly)

This driver uses the Bit.ly API version 4, which requires an access token. Currently only _generic access tokens_ are
supported, which you can set using the `BIT_LY_API_TOKEN` environment variable. This driver also supports custom domains
(if you have a paid Bit.ly account) which can be set through the `BIT_LY_DOMAIN` environment variable.

### Is.gd / V.gd
[website](https://is.gd)

This driver uses the is.gd and v.gd APIs. By default it uses is.gd, to switch to v.gd set the`IS_GD_LINK_PREVIEWS`
environment variable to `true`. This driver also supports link statics, to enable statistics set the `IS_GD_STATISTICS`
environment variable to `true`.

### Shorte.st
[website](https://shorte.st)

This driver uses the Shorte.st API, which requires an access token. You can set this token by adding the
`SHORTE_ST_API_TOKEN` environment variable or publishing and editing the package config file.

### TinyURL
[website](http://tinyurl.com)

This driver uses the TinyURL API and does not require any additional setup, this driver is also the package default.
