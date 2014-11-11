<?php namespace Conductor\Laravel;


use Conductor\ExecutionBus;
use Conductor\Inflector;
use Illuminate\Support\ServiceProvider;

class ConductorServiceProvider extends ServiceProvider
{

    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Conductor\Contracts\Resolver', function($app) {
            return new ConductorResolver($app->make('app'));
        });

        $this->app->bind('Conductor\Contracts\Conductor', function ($app) {

            $inflector = new Inflector;

            $logger = $app->make('log');

            return new ExecutionBus($app, $inflector, $logger);

        });

        $this->app->bindShared('conductor.command.make', function($app)
        {
            return $app->make('Conductor\Commands\CreateTrack');
        });

        $this->commands('conductor.command.make');
    }

    public function provides()
    {
        return ['conductor'];
    }
}
