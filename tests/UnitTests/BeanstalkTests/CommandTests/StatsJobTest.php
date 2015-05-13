<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\StatsJobTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Commands\StatsJobCommand as BeanstalkCommandStatsJob;
use \Beanstalk\Exception as BeanstalkException;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandStatsJob(123);
        $this->assertEquals('stats-job 123', $command->getCommand());

        $command = new BeanstalkCommandStatsJob(543);
        $this->assertEquals('stats-job 543', $command->getCommand());
    }

    public function testGetCommandForcesIdToInteger()
    {
        $command = new BeanstalkCommandStatsJob('hello');
        $this->assertEquals('stats-job 0', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandStatsJob(123);
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new BeanstalkCommandStatsJob(123);
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccessReturnsBeanstalkStats()
    {
        $command = new BeanstalkCommandStatsJob(123);
        $this->assertInstanceOf('\\Beanstalk\\Stats', $command->parseResponse('OK 256'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::NOT_FOUND);

        $command = new BeanstalkCommandStatsJob(123);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherError()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandStatsJob(123);
        $command->parseResponse('This is wack');
    }

}
