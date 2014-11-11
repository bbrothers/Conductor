<?php namespace Conductor\Laravel\Commands;

use Conductor\Commands\InputParser;
use Conductor\Commands\TrackGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateTrack extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'conductor:track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Conductor Track (Request, Handler and Response).';
    /**
     * @var InputParser
     */
    private $parser;
    /**
     * @var TrackGenerator
     */
    private $generator;

    /**
     * Create a new command instance.
     *
     * @param InputParser    $parser
     * @param TrackGenerator $generator
     * @return void
     */
    public function __construct(InputParser $parser, TrackGenerator $generator)
    {

        parent::__construct();
        $this->parser = $parser;
        $this->generator = $generator;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        $name       = $this->argument('name');
        $properties = $this->option('properties');
        $path       = $this->option('path');

        // Parse the command input.
        $parsedInput  = $this->parser->parse($name, $properties);

        // Actually create the files with the correct boilerplate.
        $this->generator->make($parsedInput, $path);

        $this->info('Conductor Track Created');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {

        return [
            ['name', InputArgument::REQUIRED, 'Conductor Track Name (including namespace)', null],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {

        return [
            ['properties', null, InputOption::VALUE_OPTIONAL, 'Request DTO properties', null],
            ['path', null, InputOption::VALUE_OPTIONAL, 'Directory to put the generated files', null],
        ];

    }

}
