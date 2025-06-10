[![Test](https://github.com/mlocati/http_client_compat/actions/workflows/tests.yml/badge.svg)](https://github.com/mlocati/http_client_compat/actions/workflows/tests.yml)

## A Concrete package to help performing HTTP request

This package provides an easy way to perform HTTP request in various ConcreteCMS/concrete5 version.

Sample code:

```php
$client = app(CHttpClient\Client::class);
$response = $client->get('https://www.example.org/');
```
