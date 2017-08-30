# Wicked Reports PHP SDK (beta)

## Documentation
You can find current API documentation [in this doc](https://wickedreports.helpdocs.com/getting-started-with-wicked-reports/wicked-reports-api-documentation).

## Install

Using the composer CLI:

```
composer require wickedreports/php-sdk
```

Or manually add it to your composer.json:

``` json
{
    "require": {
        "wickedreports/php-sdk": "0.1.*"
    }
}
```

## Authentication
To use API SDK, you should have your own API key.

```php
$api = new \WickedReports\WickedReports($yourApiKey);
$api->addOrders($orders);
```

## Examples
You can see list of usage examples in `examples/example.php` file.


## Dates

DateTime objects are used instead of a DateTime string where the date(time) is a parameter in the method.

```php
$datetime = new \DateTime('now',new \DateTimeZone('America/New_York'));
```

As other way, you can use simple date-time string __with `timezone` property set.__

```php
[
    'CreateDate' => '2017-08-01 00:05:01',
    'timezone'   => 'EST'
]
```

You can see list of supported timezones on [PHP.net website](http://php.net/manual/en/timezones.php).

Provided date-time string will be automatically converted to UTC timezone, as it requires our API documentation.

## Testing

``` bash
$ phpunit
```


## License

The MIT License (MIT). Please see [License File](https://github.com/wickedreports/php-sdk/blob/master/LICENSE) for more information.