<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\StatsTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Stats;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new Stats();
        $this->assertEquals('stats', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new Stats();
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new Stats();
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccessReturnsBeanstalkStats()
    {
        $command = new Stats();
        $this->assertInstanceOf('\Beanstalk\Stats', $command->parseResponse('OK 256'));
    }

    public function testParseResponseOnError()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Stats();
        $command->parseResponse('This is wack');
    }

}
