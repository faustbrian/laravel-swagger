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

namespace BrianFaust\Swagger;

use DB;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;
use Schema;
use Swagger\Analysis;
use Swagger\Annotations\Definition;
use Swagger\Annotations\Property;
use Swagger\Context;

class ModelAnalysis
{
    /** @var array */
    private $models = [];

    /**
     * @param array $models
     */
    public function __construct(array $models = [])
    {
        $this->models = $models;
    }

    /**
     * Load the given Eloquent Models into Swagger.
     *
     * @param \Swagger\Analysis $analysis
     */
    public function __invoke(Analysis $analysis)
    {
        foreach ($this->models as $model) {
            $obj = new $model();

            if ($obj instanceof Model) {
                $reflection = new ReflectionClass($obj);
                $with = $reflection->getProperty('with');
                $with->setAccessible(true);

                $list = Schema::getColumnListing($obj->getTable());
                $list = array_diff($list, $obj->getHidden());

                $properties = [];

                foreach ($list as $item) {
                    $data = [
                        'property' => $item,
                        'type'     => $this->getColumnType($obj->getTable(), $item),
                    ];

                    if ($default = $this->getColumnDefault($obj->getTable(), $item)) {
                        $data['default'] = $default;
                    }

                    $properties[] = new Property($data);
                }

                foreach ($with->getValue($obj) as $item) {
                    $class = get_class($obj->{$item}()->getModel());
                    $properties[] = new Property([
                        'property' => $item,
                        'ref'      => '#/definitions/'.class_basename($class),
                    ]);
                }

                $definition = new Definition([
                    'definition' => class_basename($model),
                    'properties' => $properties,
                ]);

                $analysis->addAnnotation($definition, new Context(['-', $model]));
            }
        }
    }

    /**
     * Gets the type of the column from the database.
     *
     * @param string $table
     * @param string $column
     *
     * @return string
     */
    private function getColumnType(string $table, string $column)
    {
        return DB::connection()->getDoctrineColumn($table, $column)->getType()->getName();
    }

    /**
     * Gets the default value for a column.
     *
     * @param string $table
     * @param string $column
     *
     * @return null|string
     */
    private function getColumnDefault(string $table, string $column)
    {
        return DB::connection()->getDoctrineColumn($table, $column)->getDefault();
    }
}
