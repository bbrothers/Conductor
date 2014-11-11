<?php namespace Conductor\Tests\Unit;

use Conductor\Inflector;
use Mockery as m;

class NameInflectorTest extends BaseTestCase
{

    protected $testRequest;
    protected $nameInflector;

    public function setUp()
    {

        $this->testRequest   = m::mock('overload:TestRequest');
        $this->nameInflector = new Inflector;
    }

    /**
     * @test
     * @expectedException \Conductor\Exceptions\HandlerNotFoundException
     */
    public function itThrowsAnExceptionIfTheHandlerClassDoesNotExist()
    {
        $handler = $this->nameInflector->getHandlerClass($this->testRequest);
        $this->assertEquals($handler, 'TestHandler');
    }

    /** @test */
    public function itReturnsTheValidatorClassName()
    {

        $handler = $this->nameInflector->getValidatorClass($this->testRequest);
        $this->assertEquals($handler, 'TestValidator');
    }

    /** @test */
    public function itReturnsTheLoggerClassName()
    {

        $handler = $this->nameInflector->getLoggerClass($this->testRequest);
        $this->assertEquals($handler, 'TestLogger');
    }


}
