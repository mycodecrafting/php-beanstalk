<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\StatsTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandStats;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/Stats.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Stats.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandStats();
        $this->assertEquals('stats', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandStats();
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new BeanstalkCommandStats();
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccessReturnsBeanstalkStats()
    {
        $command = new BeanstalkCommandStats();
        $this->assertInstanceOf('BeanstalkStats', $command->parseResponse('OK 256'));
    }

    public function testParseResponseOnError()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandStats();
        $command->parseResponse('This is wack');
    }

}
