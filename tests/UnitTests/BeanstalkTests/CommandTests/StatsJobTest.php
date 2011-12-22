<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\StatsJobTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandStatsJob;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/StatsJob.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Stats.php';

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
        $this->assertInstanceOf('BeanstalkStats', $command->parseResponse('OK 256'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::NOT_FOUND);

        $command = new BeanstalkCommandStatsJob(123);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherError()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandStatsJob(123);
        $command->parseResponse('This is wack');
    }

    public function run(\PHPUnit_Framework_TestResult $result = NULL)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

}
