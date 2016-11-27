# Laravel Swagger

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

``` bash
$ composer require faustbrian/laravel-swagger
```

And then include the service provider within `app/config/app.php`.

``` php
'providers' => [
    BrianFaust\Swagger\SwaggerServiceProvider::class
];
```

To get started, you'll need to publish the vendor assets:

```bash
php artisan vendor:publish --provider="BrianFaust\Swagger\SwaggerServiceProvider"
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to Brian Faust at hello@brianfaust.de. All security vulnerabilities will be promptly addressed.

## License

[MIT](LICENSE) © [Brian Faust](https://brianfaust.de)
