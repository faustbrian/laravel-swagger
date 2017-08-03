<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Swagger.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'api' => [

        /*
        |--------------------------------------------------------------------------
        | Edit to set the api's title
        |--------------------------------------------------------------------------
        */

        'title' => 'Swagger UI',

        /*
        |--------------------------------------------------------------------------
        | Edit to set the api's Auth token
        |--------------------------------------------------------------------------
        */

        'auth_token' => env('SWAGGER_API_AUTH_TOKEN', false),

        /*
        |--------------------------------------------------------------------------
        | Edit to set the api key variable in interface
        |--------------------------------------------------------------------------
        */

        'key_var' => env('SWAGGER_API_KEY_VAR', 'api_key'),

        /*
        |--------------------------------------------------------------------------
        | Edit to set the securityDefinition that is used in requests
        |--------------------------------------------------------------------------
        */

        'security_definition' => env('SWAGGER_API_SECURITY_DEFINITION', 'api_key'),

        /*
        |--------------------------------------------------------------------------
        | Edit to set where to inject api key (header, query)
        |--------------------------------------------------------------------------
        */

        'key_inject' => env('SWAGGER_API_KEY_INJECT', 'query'),

        /*
        |--------------------------------------------------------------------------
        | Edit to set the api's version number
        |--------------------------------------------------------------------------
        */

        'version' => env('SWAGGER_API_VERSION', '1'),

        /*
        |--------------------------------------------------------------------------
        | Edit to set the swagger version number
        |--------------------------------------------------------------------------
        */

        'swagger_version' => env('SWAGGER_DEFAULT_API_VERSION', '1'),

    ],

    'routes' => [

        /*
        |--------------------------------------------------------------------------
        | Route for accessing api documentation interface
        |--------------------------------------------------------------------------
        */

        'api' => 'api/docs',

        /*
        |--------------------------------------------------------------------------
        | Route for accessing parsed swagger annotations.
        |--------------------------------------------------------------------------
        */

        'docs' => 'docs',

    ],

    'paths' => [

        /*
        |--------------------------------------------------------------------------
        | Absolute path to location where parsed swagger annotations will be stored
        |--------------------------------------------------------------------------
        */

        'docs' => storage_path('api-docs'),

        /*
        |--------------------------------------------------------------------------
        | File name of the generated json documentation file
        |--------------------------------------------------------------------------
        */

        'docs_json' => 'api-docs.json',

        /*
        |--------------------------------------------------------------------------
        | Absolute path to directory containing the swagger annotations are stored.
        |--------------------------------------------------------------------------
        */

        'annotations' => app_path('Http/Controllers'),

        /*
        |--------------------------------------------------------------------------
        | Absolute path to directory containing the swagger annotations are stored.
        |--------------------------------------------------------------------------
        */

        'models' => app_path('Models'),

        /*
        |--------------------------------------------------------------------------
        | Absolute path to directory where to export assets
        |--------------------------------------------------------------------------
        */

        'assets' => public_path('vendor/laravel-swagger'),

        /*
        |--------------------------------------------------------------------------
        | Path to assets public directory
        |--------------------------------------------------------------------------
        */

        'assets_public' => '/vendor/laravel-swagger',

        /*
        |--------------------------------------------------------------------------
        | Absolute path to directory where to export views
        |--------------------------------------------------------------------------
        */

        'views' => resource_path('views/vendor/laravel-swagger'),

        /*
        |--------------------------------------------------------------------------
        | Edit to set the api's base path
        |--------------------------------------------------------------------------
        */

        'base' => env('SWAGGER_BASE_PATH', null),

        /*
        |--------------------------------------------------------------------------
        | Absolute path to directories that you would like to exclude from swagger generation
        |--------------------------------------------------------------------------
        */

        'excludes' => [],

    ],

    /*
    |--------------------------------------------------------------------------
    | Turn this off to remove swagger generation on production
    |--------------------------------------------------------------------------
    */

    'generate_always' => env('SWAGGER_GENERATE_ALWAYS', false),

    /*
    |--------------------------------------------------------------------------
    | Edit to set the swagger version number
    |--------------------------------------------------------------------------
    */

    'swagger_version' => env('SWAGGER_VERSION', '2.0'),

    /*
    |--------------------------------------------------------------------------
    | Edit to trust the proxy's ip address - needed for AWS Load Balancer
    |--------------------------------------------------------------------------
    */

    'proxy' => false,

    /*
    |--------------------------------------------------------------------------
    | Edit to change layout of GUI ( 'none', 'list' or 'full')
    |--------------------------------------------------------------------------
    */

    'docExpansion' => env('SWAGGER_DOC_EXPANSION', 'none'),

    /*
    |--------------------------------------------------------------------------
    | Edit to change the maximum number of characters to highlight code.
    |--------------------------------------------------------------------------
    */
    'highlightThreshold' => env('SWAGGER_HIGHLIGHT_THRESHOLD', 5000),

    /*
    |--------------------------------------------------------------------------
    | Uncomment to pass the validatorUrl parameter to SwaggerUi init on the JS
    | side.  A null value here disables validation.  A string will override
    | the default url.  If not specified, behavior is default and validation
    | is enabled.
    |--------------------------------------------------------------------------
    */

    //'validatorUrl' => null,

    'headers' => [

        /*
        |--------------------------------------------------------------------------
        | Uncomment to add response headers when swagger is generated
        |--------------------------------------------------------------------------
        */

        //'view' => [
        //  'Content-Type' => 'text/plain',
        //],

        /*
        |--------------------------------------------------------------------------
        | Uncomment to add request headers when swagger performs requests
        |--------------------------------------------------------------------------
        */

        //'request' => [
        //  'TestMe' => 'testValue',
        //],

    ],

    /*
    |--------------------------------------------------------------------------
    | Uncomment to add constants which can be used in anotations
    |--------------------------------------------------------------------------
     */
    'constants' => [
        //'SWAGGER_CONST_HOST' => env('SWAGGER_CONST_HOST', 'http://my-default-host.com'),
    ],

];
