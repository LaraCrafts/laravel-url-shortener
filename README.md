# laravel-url-shortener
Powerful URL shortening tools in Laravel

<p align="center">
    <a href="https://travis-ci.org/LaraCrafts/laravel-url-shortener"><img src="https://travis-ci.org/LaraCrafts/laravel-url-shortener.svg?branch=master"></a>
    <a href="https://packagist.org/packages/laracrafts/laravel-url-shortener"><img src="https://poser.pugx.org/laracrafts/laravel-url-shortener/downloads"></a>
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
    - [Changing the driver](#changing-the-driver)
    - [Adding your own drivers](#adding-your-own-drivers)
- [Available drivers](#available-drivers)
    - [Bit.ly](#bitly)
    - [Is.gd](#isgd--vgd)
    - [Ouo.io](#ouoio)
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

### Changing the driver
You can change the default driver by setting `URL_SHORTENER_DRIVER={driver}` in your environment file or publishing the
config file and changing it directly.

### Adding your own drivers
Much like Laravels [core components](https://laravel.com/docs/5.0/extending#managers-and-factories), you can add your
own drivers for this package. You can do this by adding the following code to a central place in your application
(preferably a service provider).

```php
UrlShortener::extend('my_driver', function () {
    return new MyCustomUrlShortener();
});
```

If you are adding a web hosted shortener service you may want to extend the `RemoteShortener` abstract class, for which
you can use the shipped drivers (e.g. `TinyUrlShortener`) as an example as to how.

If you wrote a custom driver that others might find useful (such as a public online shortener service), please consider
adding it to the package via a pull request.

## Available drivers
Below is a list of available drivers along with their individual specs:

Service                | Driver name | Since version | Analytics | Monetization
-----------------------|-------------|---------------|-----------|-----------------
[Bit.ly](#bitly)       | `bit_ly`    | 0.1.0         | yes       | no
[Is.gd](#isgd--vgd)    | `is_gd`     | 0.2.0         | yes       | no
[Ouo.io](#ouoio)       | `ouo_io`    | 0.2.0         | yes       | yes
[Shorte.st](#shortest) | `shorte_st` | 0.1.0         | yes       | yes
[TinyURL](#tinyurl)    | `tiny_url`  | 0.1.0         | no        | no
[V.gd](#isgd--vgd)     | `is_gd`     | 0.2.0         | yes       | no

### Bit.ly
[website](https://bit.ly)

This driver runs on Bit.ly's API and currently only supports API version 4. The API requires an access token and
currently only _generic access tokens_ are supported. You can retrieve such tokens from your Bit.ly profile. If you have
a paid Bit.ly account you will also be able to set the domain for your shortened URLs.

Variable           | Description
-------------------|----------------------
`BIT_LY_API_TOKEN` | Your Bit.ly API token
`BIT_LY_DOMAIN`    | Your short URL domain

### Is.gd / V.gd
[website](https://is.gd)

This driver supports [is.gd](https://is.gd) and [v.gd](https://v.gd) trough their respective APIs. When link previews
are enabled v.gd will be used, otherwise is.gd will be used.

Variable              | Description
----------------------|----------------------------------------
`IS_GD_LINK_PREVIEWS` | Enable or disable destination previews
`IS_GD_STATISTICS`    | Enable or disable statistics

### Ouo.io
[website](https://ouo.io)

This driver uses the Ouo.io API and requires an access token. The API allows for URL monetization via advertisements and
provides analytics via its dashboard.

Variable           | Description 
-------------------|----------------------
`OUO_IO_API_TOKEN` | Your Ouo.io API token

### Shorte.st
[website](https://shorte.st)

This driver uses the Shorte.st API, which requires an access token. This API supports monetization of your URLs and can
give you insight into your traffic via its dashboard.

Variable              | Description
----------------------|-------------------------
`SHORTE_ST_API_TOKEN` | Your Shorte.st API token

### TinyURL
[website](http://tinyurl.com)

This driver runs on the TinyURL API, which requires no additional setup. This driver is the package default.
