<?php



Route::any(config('laravel-swagger.routes.docs').'/{jsonFile?}', [
    'as'   => 'laravel-swagger.docs',
    'uses' => '\BrianFaust\Swagger\Http\Controllers\SwaggerController@docs',
]);

Route::get(config('laravel-swagger.routes.api'), [
    'as'   => 'laravel-swagger.api',
    'uses' => '\BrianFaust\Swagger\Http\Controllers\SwaggerController@api',
]);
