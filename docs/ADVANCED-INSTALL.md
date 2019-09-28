# Advanced installation guide
Use this guide if you want to install this package with HTTP libraries of your choice.

## PSR-7
Install a PSR-7 [packages](https://packagist.org/providers/psr/http-message-implementation), this will most likely be
the same as your PSR-17 package. No additional steps are required aside from installing the package.

## PSR-17
Install a [PSR-17 package](https://packagist.org/providers/psr/http-factory-implementation). Afterwards register the
UriFactory implementation to your application's container. You can do this by adding the following line of code to the
register method of one of your application's service providers (found in app/Providers).

Example:
```php
public function register()
{
    $this->app->bind('\Psr\Http\Message\UriFactoryInterface', '\Zend\Diactoros\UriFactory');
}
```

> This example is for Zend Diactoros, if you want to use another package replace
`\Zend\Diactoros\UriFactory` with your chosen URI factory.

## PSR-18
First, install the [PSR-18 package](https://packagist.org/providers/psr/http-client-implementation), then register the
HTTP client to your application's container. You can do this by adding the following line of code to the register method
of one of your application's service providers (found in app/Providers).

Example:

```php
public function register()
{
    $this->app->bind('\Psr\Http\Client\ClientInterface', '\Symfony\Component\HttpClient\Psr18Client');
}
```

> This example is for Symfony's HttpClient component, if you want to use another package replace
`\Symfony\Component\HttpClient\Psr18Client` with your chosen HTTP client.
