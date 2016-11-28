# API-php Boilerplate

[![Latest Version](https://img.shields.io/github/release/api-php/boilerplate.svg?style=flat-square)](https://github.com/api-php/boilerplate/releases)
[![Build Status](https://img.shields.io/travis/api-php/boilerplate.svg?style=flat-square)](https://travis-ci.org/api-php/boilerplate)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/api-php/boilerplate.svg?style=flat-square)](https://scrutinizer-ci.com/g/api-php/boilerplate)
[![Quality Score](https://img.shields.io/scrutinizer/g/api-php/boilerplate.svg?style=flat-square)](https://scrutinizer-ci.com/g/api-php/boilerplate)
[![Total Downloads](https://img.shields.io/packagist/dt/api-php/boilerplate.svg?style=flat-square)](https://packagist.org/packages/api-php/boilerplate)


## Install

Via Composer

``` bash
$ composer require api-php/boilerplate
```

## Usage

```php
$apiClient = new ApiClient();
$response = $apiClient->stats()->total();
echo $response->getCount(); // 22;
```

## Develop

You should split your API into categories. Each of those categories should have their own class in `API/`. 
Example `Api/Stats`. The response of any call should be an object in `Resource/Api/X`. Example 
`Resource/Api/Stats/TotalResponse`.

## Deserialzier

The end user chooses what deserialzier to use. By default one should return domain objects. 

# Request builder

The request builder will build request with multipart streams when necessary. 

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
