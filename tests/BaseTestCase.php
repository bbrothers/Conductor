<?php namespace Conductor\Tests\Unit;

use Mockery as m;

abstract class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {

        m::close();
    }
}
