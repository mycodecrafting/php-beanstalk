<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\ReleaseTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandRelease;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/Release.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandRelease(1098, 1024, 5);
        $this->assertEquals('release 1098 1024 5', $command->getCommand());

        $command = new BeanstalkCommandRelease(123, 10, 60);
        $this->assertEquals('release 123 10 60', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandRelease(1098, 1024, 5);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new BeanstalkCommandRelease(1098, 1024, 5);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandRelease(1098, 1024, 5);
        $this->assertTrue($command->parseResponse('RELEASED'));
    }

    public function testParseResponseOnBuried()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::BURIED);

        $command = new BeanstalkCommandRelease(1098, 1024, 5);
        $command->parseResponse('BURIED');
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::NOT_FOUND);

        $command = new BeanstalkCommandRelease(1098, 1024, 5);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandRelease(1098, 1024, 5);
        $command->parseResponse('This is wack');
    }

    public function run(\PHPUnit_Framework_TestResult $result = NULL)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

}
