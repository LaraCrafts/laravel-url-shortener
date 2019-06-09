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
- [Usage](#usage)
    - [Changing the driver](#changing-the-driver)
    - [Adding your own drivers](#adding-your-own-drivers)
- [Available drivers](#available-drivers)
    - [Bit.ly](#bitly)
    - [Firebase Dynamic Links](#firebase-dynamic-links)
    - [Is.gd](#isgd--vgd)
    - [Ouo.io](#ouoio)
    - [Polr](#polr)
    - [Shorte.st](#shortest)
    - [TinyURL](#tinyurl)
    - [V.gd](#isgd--vgd)
- [Changelog](#changelog)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)
    
## Installation
You can easily install this package using Composer, by running the following command:

```bash
composer require laracrafts/laravel-url-shortener
```

### Requirements
This package has the following requirements:

- PHP 7.1 or higher
- Laravel 5.1 or higher

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

## Usage
The shortener can be retrieved from the container in two ways:

```php
$shortener = app('url.shortener');
// or...
$shortener = url()->shortener();
```

Once you have an instance of the shortener, you can shorten your URLs:

```php
// This will return your shortened URL as a string
$shortener->shorten(...);

// This will return a promise which will resolve to your shortened URL
$shortener->shortenAsync(...);

// You can also call shortening from Laravel's url component directly
url()->shorten(...);

// or...
app('url')->shorten(...);

// or even...
app('url.shortener')->shorten(...);
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
`extend`       | Register your own driver

### Changing the driver
You can change the default driver by setting `URL_SHORTENER_DRIVER={driver}` in your environment file or publishing the
config file and changing it directly.

### Adding your own drivers
Much like Laravel's [core components](https://laravel.com/docs/5.0/extending#managers-and-factories), you can add your
own drivers for this package. You can do this by adding the following code to a central place in your application
(preferably a service provider).

```php
public function boot(ShortenerManager $shorteners)
{
    $shorteners->extend('my_driver', function ($app, $config) {
       // Return your driver instance here
    });
}
```

Once you have registered your driver you can call it like any other driver.

If you wrote a custom driver that others might find useful (such as a public online shortener service), please consider
adding it to the package via a pull request.

## Available drivers
Below is a list of available drivers along with their individual specs:

Service                                           | Driver name | Since version | Analytics | Monetization
--------------------------------------------------|-------------|---------------|-----------|-----------------
[Bit.ly](#bitly)                                  | `bit_ly`    | 0.1.0         | yes       | no
[Firebase Dynamic Links](#firebase-dynamic-links) | `firebase`  | 0.2.0         | yes       | no
[Is.gd](#isgd--vgd)                               | `is_gd`     | 0.2.0         | yes       | no
[Ouo.io](#ouoio)                                  | `ouo_io`    | 0.2.0         | yes       | yes
[Polr](#polr)                                     | `polr`      | 0.3.0         | yes       | no
[Shorte.st](#shortest)                            | `shorte_st` | 0.1.0         | yes       | yes
[TinyURL](#tinyurl)                               | `tiny_url`  | 0.1.0         | no        | no
[V.gd](#isgd--vgd)                                | `is_gd`     | 0.2.0         | yes       | no

### Bit.ly
[website](https://bit.ly)

This driver runs on Bit.ly's API and currently only supports API version 4. The API requires an access token and
currently only _generic access tokens_ are supported. You can retrieve such tokens from your Bit.ly profile. If you have
a paid Bit.ly account you will also be able to set the domain for your shortened URLs.

Variable                  | Description
--------------------------|----------------------
`URL_SHORTENER_API_TOKEN` | Your Bit.ly API token
`URL_SHORTENER_PREFIX`    | Your short URL domain

### Firebase Dynamic Links
[website](https://firebase.google.com/)

This driver runs on Firebase's API. The API requires an access token, a URI prefix and a suffix. You can access these
information on you firebase console. The token accessible under the project settings as "Web API Key" and the prefixes
can be defined and accessed under the Dynamic Links menu. 

The suffix can have the value `SHORT` or `UNGUESSABLE`.

> **IMPORTANT!** Links created via the API are not visible in the Firebase console. They are only accessible via
> the [Analytics REST API](https://firebase.google.com/docs/reference/dynamic-links/analytics).

Variable                 | Description                        | Default
-------------------------|------------------------------------|---------------
`URL_SHORTENER_API_TOKEN`| Your Firebase API token            |
`URL_SHORTENER_PREFIX`   | Your URL prefix                    |
`URL_SHORTENER_STRATEGY` | The path component creation method | `UNGUESSABLE`

### Is.gd / V.gd
[website](https://is.gd)

This driver supports [is.gd](https://is.gd) and [v.gd](https://v.gd) trough their respective APIs. When link previews
are enabled v.gd will be used, otherwise is.gd will be used.

Variable                  | Description
--------------------------|----------------------------------------
`URL_SHORTENER_ANALYTICS` | Enable or disable statistics

### Ouo.io
[website](https://ouo.io)

This driver uses the Ouo.io API and requires an access token. The API allows for URL monetization via advertisements and
provides analytics via its dashboard.

Variable                  | Description 
--------------------------|----------------------
`URL_SHORTENER_API_TOKEN` | Your Ouo.io API token

### Polr
[website](https://github.com/cydrobolt/polr/)

This driver uses the Polr API. The API requires an access token and a URI prefix.

Variable                  | Description
--------------------------|-------------------------
`URL_SHORTENER_API_TOKEN` | Your Polr API token
`URL_SHORTENER_PREFIX`    | Your URL prefix

### Shorte.st
[website](https://shorte.st)

This driver uses the Shorte.st API, which requires an access token. This API supports monetization of your URLs and can
give you insight into your traffic via its dashboard.

Variable                  | Description
--------------------------|-------------------------
`URL_SHORTENER_API_TOKEN` | Your Shorte.st API token

### TinyURL
[website](http://tinyurl.com)

This driver runs on the TinyURL API, which requires no additional setup. This driver is the package default.

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information what has been changed in recent versions.

## Security
If you discover any security related issues, please email one of the authors instead of using the issue tracker. You can
find the author emails in the [composer.json](composer.json).

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits
- [Choraimy Kroonstuiver](https://github.com/axlon)
- [László Görög](https://github.com/nerg4l)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
