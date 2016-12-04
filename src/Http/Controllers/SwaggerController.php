<?php

/*
 * This file is part of Laravel Swagger.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

/*
 * This file is part of Laravel Swagger.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Swagger\Http\Controllers;

use BrianFaust\Swagger\Generator;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class SwaggerController extends BaseController
{
    /**
     * Dump api-docs.json content endpoint.
     *
     * @param string $jsonFile
     *
     * @return \Illuminate\Http\Response
     */
    public function docs(Request $request, $jsonFile = null)
    {
        $filePath = config('laravel-swagger.paths.docs').'/'.
            (!is_null($jsonFile) ? $jsonFile : config('laravel-swagger.paths.docs_json', 'api-docs.json'));

        if (File::extension($filePath) === '') {
            $filePath .= '.json';
        }

        if (!File::exists($filePath)) {
            abort(404, 'Cannot find '.$filePath);
        }

        $content = File::get($filePath);

        return response($content, 200, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * Display the Swagger API page.
     *
     * @return \Illuminate\Http\Response
     */
    public function api(Request $request)
    {
        if (config('laravel-swagger.generate_always')) {
            (new Generator())->generateDocs();
        }

        if (config('laravel-swagger.proxy')) {
            $proxy = $request->server('REMOTE_ADDR');

            $request->setTrustedProxies([$proxy]);
        }

        $extras = [];
        if (array_key_exists('validatorUrl', config('laravel-swagger'))) {
            // This allows for a null value, since this has potentially
            // desirable side effects for swagger. See the view for more
            // details.
            $extras['validatorUrl'] = config('laravel-swagger.validatorUrl');
        }

        // Need the / at the end to avoid CORS errors on Homestead systems.
        $response = response(
            view('laravel-swagger::index', [
                'apiKey'             => config('laravel-swagger.api.auth_token'),
                'apiKeyVar'          => config('laravel-swagger.api.key_var'),
                'securityDefinition' => config('laravel-swagger.api.security_definition'),
                'apiKeyInject'       => config('laravel-swagger.api.key_inject'),
                'secure'             => $request->secure(),
                'urlToDocs'          => route('laravel-swagger.docs', config('laravel-swagger.paths.docs_json', 'api-docs.json')),
                'requestHeaders'     => config('laravel-swagger.headers.request'),
                'docExpansion'       => config('laravel-swagger.docExpansion'),
                'highlightThreshold' => config('laravel-swagger.highlightThreshold'),

                'assetsPath' => config('laravel-swagger.paths.assets_public'),
            ], $extras),
            200
        );

        $headersView = config('laravel-swagger.headers.view');
        if (is_array($headersView) and !empty($headersView)) {
            foreach ($headersView as $key => $value) {
                $response->header($key, $value);
            }
        }

        return $response;
    }
}
