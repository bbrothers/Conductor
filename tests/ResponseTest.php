<?php namespace Conductor\Tests\Unit;


use Conductor\Tests\Stubs\FooResponse;

class ResponseTest extends BaseTestCase
{

    /** @test */
    public function itReturnsAnInvokableResponse()
    {

        $response = new FooResponse('foobar');

        $this->assertEquals('foobar', $response());
    }
}
