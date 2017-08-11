# Wicked Reports PHP SDK

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



### Dates

DateTime objects are used instead of a DateTime string where the date(time) is a parameter in the method.

```php
$datetime = new \DateTime('now',new \DateTimeZone('America/New_York'));
```

## Testing

``` bash
$ phpunit
```


## License

The MIT License (MIT). Please see [License File](https://github.com/wickedreports/php-sdk/blob/master/LICENSE) for more information.