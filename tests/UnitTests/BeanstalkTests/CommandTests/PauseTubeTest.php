<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\PauseTubeTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandPauseTube;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/PauseTube.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';

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
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::NOT_FOUND);

        $command = new BeanstalkCommandPauseTube('tube-name', 30);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandPauseTube('tube-name', 30);
        $command->parseResponse('This is wack');
    }

    public function run(\PHPUnit_Framework_TestResult $result = NULL)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

}
