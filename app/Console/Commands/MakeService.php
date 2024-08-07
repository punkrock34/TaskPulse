<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';

    protected $description = 'Create a new service class';

    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->getPath($name);

        if ($this->files->exists($path)) {
            $this->error("Service {$name} already exists!");

            return;
        }

        $this->makeDirectory($path);

        $stub = $this->files->get($this->getStub());

        $this->files->put($path, $this->replaceNamespace($stub, $name));

        $this->info("Service {$name} created successfully.");
    }

    protected function getStub()
    {
        return base_path('stubs/service.stub');
    }

    protected function getPath($name)
    {
        return app_path('Services').'/'.Str::studly($name).'.php';
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    protected function replaceNamespace($stub, $name)
    {
        return str_replace('{{ class }}', Str::studly($name), $stub);
    }
}
