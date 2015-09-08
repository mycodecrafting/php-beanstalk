<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\ReserveTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Reserve;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new Reserve();
        $this->assertEquals('reserve', $command->getCommand());
    }

    public function testGetCommandWithTimeout()
    {
        $command = new Reserve(120);
        $this->assertEquals('reserve-with-timeout 120', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new Reserve();
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new Reserve();
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new Reserve();

        $conn = $this->getMock('Beanstalk\Connection', array('connect'), array('localhost:11300', $this->getMock('Beanstalk\Connection\Stream')));
        $job = $command->parseResponse('RESERVED 1244 2048', '{"content":"something"}', $conn);

        $this->assertInstanceOf('Beanstalk\Job', $job);
        $this->assertEquals(1244, $job->getId());
    }

    public function testParseResponseOnDeadlineSoon()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::DEADLINE_SOON);

        $command = new Reserve();
        $command->parseResponse('DEADLINE_SOON');
    }

    public function testParseResponseOnTimedOut()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::TIMED_OUT);

        $command = new Reserve();
        $command->parseResponse('TIMED_OUT');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Reserve();
        $command->parseResponse('This is wack');
    }

}
