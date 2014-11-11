<?php namespace Conductor\Tests\Unit;

use Conductor\Decorators\Validation;
use Conductor\ExecutionBus;
use Mockery as m;

class ResolutionTest extends BaseTestCase
{

    protected $inflector;
    protected $resolver;
    protected $writer;

    protected function setUp()
    {

        $this->inflector = m::mock('Conductor\Contracts\NameInflector');
        $this->resolver = m::mock('Conductor\Contracts\Resolver');
        $this->writer    = m::mock('Psr\Log\LoggerInterface');
    }

    /** @test */
    public function theExecutionBusResolves()
    {

        $executionBus = new ExecutionBus($this->resolver, $this->inflector, $this->writer);

        $this->assertInstanceOf('Conductor\ExecutionBus', $executionBus);
    }

    /** @test */
    public function theValidationBusResolves()
    {

        $validationBus = new Validation($this->resolver, $this->inflector, $this->writer);

        $this->assertInstanceOf('Conductor\Decorators\Validation', $validationBus);
    }

    /** @test */
    public function itDecoratesTheValidationBus()
    {

        $validationBus = $this->getMock('Conductor\Contracts\Conductor');

        $request = m::mock('Conductor\Contracts\Request');
        $handler = m::mock('Conductor\Contracts\Handler')
                    ->shouldReceive('handle')
                    ->with($request)->once()
                    ->andReturn(true)->getMock();

        $this->inflector->shouldReceive('getHandlerClass')
                        ->with($request)
                        ->once()
                        ->andReturn('handler');

        $this->resolver->shouldReceive('resolve')
                        ->once()->with('Conductor\Decorators\Validation')
                        ->andReturn($validationBus);

        $this->resolver->shouldReceive('resolve')
                        ->once()->andReturn($handler);

        $executionBus = new ExecutionBus($this->resolver, $this->inflector, $this->writer);

        $executionBus->execute($request);
    }
}
