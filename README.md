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

## Example

This repository contains an example API client for FakeTwitter. The API server 
for FakeTwitter has the following endpoints. 
 
| Method | URI | Parameters |
| ------ | --- | ---------- |
| GET | /v1/tweets | (string) hashtag |
| POST | /v1/tweets/new | (string) message, (string) location, (array) hashtags |
| GET | /v1/tweets/{id} | |
| PUT | /v1/tweets/{id}/edit | (string) message, (string) location, (array) hashtags |
| DELETE | /v1/tweets/{id}/delete | |
| GET | /v1/stats/{username} | (int) start, (int) end |
| GET | /v1/stats/total | (int) start, (int) end|


## Develop

You should split your API into categories. Each of those categories should have their own class in `API/`. 
Example `Api/Stats`. The response of any call should be an object in `Resource/Api/X`. Example 
`Resource/Api/Stats/TotalResponse`.

### ResponseHydrator

The end user chooses what hydrator to use. By default, one should return domain objects. 

### Request builder

The request builder will build request with multipart streams when necessary. 

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
