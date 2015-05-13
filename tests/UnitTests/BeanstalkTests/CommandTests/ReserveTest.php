<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\ReserveTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Commands\ReserveCommand as BeanstalkCommandReserve;
use \Beanstalk\Exception as BeanstalkException;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandReserve();
        $this->assertEquals('reserve', $command->getCommand());
    }

    public function testGetCommandWithTimeout()
    {
        $command = new BeanstalkCommandReserve(120);
        $this->assertEquals('reserve-with-timeout 120', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandReserve();
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new BeanstalkCommandReserve();
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandReserve();

        $conn = $this->getMock('\\Beanstalk\\Connection', array('connect'), array('localhost:11300', $this->getMock('\\Beanstalk\\Connections\\Stream')));
        $job = $command->parseResponse('RESERVED 1244 2048', '{"content":"something"}', $conn);

        $this->assertInstanceOf('\\Beanstalk\\Job', $job);
        $this->assertEquals(1244, $job->getId());
    }

    public function testParseResponseOnDeadlineSoon()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::DEADLINE_SOON);

        $command = new BeanstalkCommandReserve();
        $command->parseResponse('DEADLINE_SOON');
    }

    public function testParseResponseOnTimedOut()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::TIMED_OUT);

        $command = new BeanstalkCommandReserve();
        $command->parseResponse('TIMED_OUT');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandReserve();
        $command->parseResponse('This is wack');
    }

}
