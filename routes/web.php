<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Swagger.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::any(config('laravel-swagger.routes.docs').'/{jsonFile?}', [
    'as'   => 'laravel-swagger.docs',
    'uses' => '\Artisanry\Swagger\Http\Controllers\SwaggerController@docs',
]);

Route::get(config('laravel-swagger.routes.api'), [
    'as'   => 'laravel-swagger.api',
    'uses' => '\Artisanry\Swagger\Http\Controllers\SwaggerController@api',
]);
