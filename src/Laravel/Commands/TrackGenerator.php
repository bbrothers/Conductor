<?php namespace Conductor\Laravel\Commands;

use Illuminate\Filesystem\Filesystem;
use Mustache_Engine as Mustache;

class TrackGenerator
{

    /**
     * The Filesystem instance.
     *
     * @var Filesystem
     */
    protected $file;
    /**
     * The Mustache_Engine instance.
     *
     * @var Mustache
     */
    protected $mustache;

    protected $types = ['Request', 'Handler', 'Response'];

    /**
     * @param Filesystem $file
     * @param Mustache   $mustache
     */
    public function __construct(Filesystem $file, Mustache $mustache)
    {

        $this->file     = $file;
        $this->mustache = $mustache;
    }

    /**
     * Generate a new conductor track (request, handler and response).
     *
     * @param CliInput $input
     * @param          $path
     */
    public function make(CliInput $input, $path)
    {

        if(empty($path)) {
            $path = base_path() . '/' . str_replace('\\', '/', $input->namespace);
        }

        foreach($this->types as $type) {
            $template = $this->file->get(__DIR__.'/stubs/' . strtolower($type) . '.stub');
            $stub     = $this->mustache->render($template, $input);
            $this->preparePath($path);
            $this->file->put("{$path}/{$input->name}{$type}.php", $stub);
        }
    }

    private function preparePath($path)
    {
        if (! $this->file->isDirectory($path)) {
            $this->file->makeDirectory($path);
        }
    }
}
