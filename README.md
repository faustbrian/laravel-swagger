# Laravel Swagger

[![Build Status](https://img.shields.io/travis/artisanry/Swagger/master.svg?style=flat-square)](https://travis-ci.org/artisanry/Swagger)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/artisanry/swagger.svg?style=flat-square)]()
[![Latest Version](https://img.shields.io/github/release/artisanry/Swagger.svg?style=flat-square)](https://github.com/artisanry/Swagger/releases)
[![License](https://img.shields.io/packagist/l/artisanry/Swagger.svg?style=flat-square)](https://packagist.org/packages/artisanry/Swagger)

Fork of [L5-Swagger](https://github.com/DarkaOnLine/L5-Swagger) with support for Definitions based on Eloquent Models & kept up-to-date with the newest [Swagger UI](https://github.com/swagger-api/swagger-ui) release.

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require artisanry/swagger
```

To get started, you'll need to publish the vendor assets:

```bash
php artisan vendor:publish --provider="Artisanry\Swagger\SwaggerServiceProvider"
```

## Testing

``` bash
$ phpunit
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to hello@basecode.sh. All security vulnerabilities will be promptly addressed.

## Credits

- [Brian Faust](https://github.com/faustbrian)
- [All Contributors](../../contributors)

## License

[MIT](LICENSE) © [Brian Faust](https://basecode.sh)
