<?php

namespace BrianFaust\Swagger\Console;

use Illuminate\Console\Command;
use L5Swagger\Generator;

class GenerateDocsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'swagger:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Swagger docs.';

    /**
     * Execute the console command.
     */
    public function fire()
    {
        (new Generator())->generateDocs();
    }
}
