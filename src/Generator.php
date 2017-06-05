<?php

/*
 * This file is part of Laravel Swagger.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Swagger;

use Config;
use File;
use Swagger\Analysis;
use Swagger\Annotations\Swagger;
use Symfony\Component\Finder\Finder;

class Generator
{
    use \Illuminate\Console\DetectsApplicationNamespace;

    public function generateDocs()
    {
        $appDir = config('laravel-swagger.paths.annotations');
        $docDir = config('laravel-swagger.paths.docs');

        if (!File::exists($docDir) || is_writable($docDir)) {
            // delete all existing documentation
            if (File::exists($docDir)) {
                File::deleteDirectory($docDir);
            }

            self::defineConstants(config('laravel-swagger.constants') ?: []);

            File::makeDirectory($docDir);
            $excludeDirs = config('laravel-swagger.paths.excludes');
            $swagger = $this->scan($appDir, [
                'exclude' => $excludeDirs,
                'models'  => $this->getModels(),
            ]);

            if (config('laravel-swagger.paths.base') !== null) {
                $swagger->basePath = config('laravel-swagger.paths.base');
            }

            $filename = $docDir.'/'.config('laravel-swagger.paths.docs_json', 'api-docs.json');
            $swagger->saveAs($filename);
        }
    }

    private function defineConstants(array $constants)
    {
        if (!empty($constants)) {
            foreach ($constants as $key => $value) {
                defined($key) || define($key, $value);
            }
        }
    }

    private function getModels()
    {
        $files = File::allFiles(config('laravel-swagger.paths.models'));

        if (empty($files)) {
            return [];
        }

        $modelNamespace = $this->getAppNamespace();
        $modelNamespace .= last(explode('/', config('laravel-swagger.paths.models')));

        $models = [];
        foreach ($files as $file) {
            $models[] = $modelNamespace.'\\'.str_replace('.php', '', $file->getBasename());
        }

        return $models;
    }

    /**
     * Same as the Swagger\scan with support for Eloquent models.
     *
     * @param string|array|Finder $directory The directory(s) or filename(s)
     * @param array               $options
     *
     * @return Swagger
     */
    private function scan($directory, $options = [])
    {
        $options['processors'] = array_get($options, 'processors', array_merge([
            new ModelAnalysis(array_get($options, 'models', [])),
        ], Analysis::processors()));

        return \Swagger\scan($directory, $options);
    }
}
