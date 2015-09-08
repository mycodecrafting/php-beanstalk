<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\PeekTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Peek;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommandPeekReady()
    {
        $command = new Peek('ready');
        $this->assertEquals('peek-ready', $command->getCommand());
    }

    public function testGetCommandPeekDelayed()
    {
        $command = new Peek('delayed');
        $this->assertEquals('peek-delayed', $command->getCommand());
    }

    public function testGetCommandPeekBuried()
    {
        $command = new Peek('buried');
        $this->assertEquals('peek-buried', $command->getCommand());
    }

    public function testGetCommandPeekId()
    {
        $command = new Peek(556);
        $this->assertEquals('peek 556', $command->getCommand());

        $command = new Peek('7798');
        $this->assertEquals('peek 7798', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new Peek(556);
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new Peek(556);
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new Peek(556);

        $conn = $this->getMock('\Beanstalk\Connection', [ 'connect' ], [ 'localhost:11300', $this->getMock('\Beanstalk\Connection\Stream') ]);
        $job = $command->parseResponse('FOUND 556 2048', '{"content":"something"}', $conn);

        $this->assertInstanceOf('Beanstalk\Job', $job);
        $this->assertEquals(556, $job->getId());
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_FOUND);

        $command = new Peek(556);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Peek(556);
        $command->parseResponse('This is wack');
    }

}
