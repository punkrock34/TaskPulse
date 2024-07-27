<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeTrait extends Command
{
    protected $signature = 'make:trait {name}';

    protected $description = 'Create a new trait';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->getPath($name);

        if ($this->files->exists($path)) {
            $this->error('Trait already exists!');

            return false;
        }

        $this->makeDirectory($path);
        $this->files->put($path, $this->buildClass($name));

        $this->info('Trait created successfully.');
    }

    protected function getPath($name)
    {
        return base_path('app/Http/Controllers/Traits/'.$name.'.php');
    }

    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }
    }

    protected function buildClass($name)
    {
        return "<?php\n\nnamespace App\Http\Controllers\Traits;\n\ntrait $name\n{\n    // Trait methods\n}\n";
    }
}
