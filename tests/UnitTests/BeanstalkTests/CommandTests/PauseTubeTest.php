<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\PauseTubeTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\PauseTube;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new PauseTube('tube-name', 30);
        $this->assertEquals('pause-tube tube-name 30', $command->getCommand());
    }

    public function testConvertsDelayToInteger()
    {
        $command = new PauseTube('tube-name', 30.5);
        $this->assertEquals('pause-tube tube-name 30', $command->getCommand());

        $command = new PauseTube('tube-name', 'bad');
        $this->assertEquals('pause-tube tube-name 0', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new PauseTube('tube-name', 30);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new PauseTube('tube-name', 30);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new PauseTube('tube-name', 30);
        $this->assertTrue($command->parseResponse('PAUSED'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_FOUND);

        $command = new PauseTube('tube-name', 30);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new PauseTube('tube-name', 30);
        $command->parseResponse('This is wack');
    }

}
