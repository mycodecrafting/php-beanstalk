<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\PeekTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandPeek;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/Peek.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Job.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Connection.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommandPeekReady()
    {
        $command = new BeanstalkCommandPeek('ready');
        $this->assertEquals('peek-ready', $command->getCommand());
    }

    public function testGetCommandPeekDelayed()
    {
        $command = new BeanstalkCommandPeek('delayed');
        $this->assertEquals('peek-delayed', $command->getCommand());
    }

    public function testGetCommandPeekBuried()
    {
        $command = new BeanstalkCommandPeek('buried');
        $this->assertEquals('peek-buried', $command->getCommand());
    }

    public function testGetCommandPeekId()
    {
        $command = new BeanstalkCommandPeek(556);
        $this->assertEquals('peek 556', $command->getCommand());

        $command = new BeanstalkCommandPeek('7798');
        $this->assertEquals('peek 7798', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandPeek(556);
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new BeanstalkCommandPeek(556);
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandPeek(556);

        $conn = $this->getMock('BeanstalkConnection', array('connect'), array('localhost:11300', $this->getMock('BeanstalkConnectionStream')));
        $job = $command->parseResponse('FOUND 556 2048', '{"content":"something"}', $conn);

        $this->assertInstanceOf('BeanstalkJob', $job);
        $this->assertEquals(556, $job->getId());
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::NOT_FOUND);

        $command = new BeanstalkCommandPeek(556);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandPeek(556);
        $command->parseResponse('This is wack');
    }

}
