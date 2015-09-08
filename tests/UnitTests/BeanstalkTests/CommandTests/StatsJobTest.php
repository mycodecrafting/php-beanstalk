<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\StatsJobTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\StatsJob;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new StatsJob(123);
        $this->assertEquals('stats-job 123', $command->getCommand());

        $command = new StatsJob(543);
        $this->assertEquals('stats-job 543', $command->getCommand());
    }

    public function testGetCommandForcesIdToInteger()
    {
        $command = new StatsJob('hello');
        $this->assertEquals('stats-job 0', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new StatsJob(123);
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new StatsJob(123);
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccessReturnsBeanstalkStats()
    {
        $command = new StatsJob(123);
        $this->assertInstanceOf('\Beanstalk\Stats', $command->parseResponse('OK 256'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_FOUND);

        $command = new StatsJob(123);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherError()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new StatsJob(123);
        $command->parseResponse('This is wack');
    }

}
