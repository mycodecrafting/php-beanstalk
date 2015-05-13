<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\PauseTubeTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Commands\PauseTubeCommand as BeanstalkCommandPauseTube;
use \Beanstalk\Exception as BeanstalkException;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandPauseTube('tube-name', 30);
        $this->assertEquals('pause-tube tube-name 30', $command->getCommand());
    }

    public function testConvertsDelayToInteger()
    {
        $command = new BeanstalkCommandPauseTube('tube-name', 30.5);
        $this->assertEquals('pause-tube tube-name 30', $command->getCommand());

        $command = new BeanstalkCommandPauseTube('tube-name', 'bad');
        $this->assertEquals('pause-tube tube-name 0', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandPauseTube('tube-name', 30);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new BeanstalkCommandPauseTube('tube-name', 30);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandPauseTube('tube-name', 30);
        $this->assertTrue($command->parseResponse('PAUSED'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::NOT_FOUND);

        $command = new BeanstalkCommandPauseTube('tube-name', 30);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandPauseTube('tube-name', 30);
        $command->parseResponse('This is wack');
    }

}
