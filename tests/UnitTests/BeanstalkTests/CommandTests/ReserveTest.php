<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\ReserveTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandReserve;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/Reserve.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Connection.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Job.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandReserve();
        $this->assertEquals('reserve', $command->getCommand());
    }

    public function testGetCommandWithTimeout()
    {
        $command = new BeanstalkCommandReserve(120);
        $this->assertEquals('reserve-with-timeout 120', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandReserve();
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new BeanstalkCommandReserve();
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandReserve();

        $conn = $this->getMock('BeanstalkConnection', array('connect'), array('localhost:11300', $this->getMock('BeanstalkConnectionStream')));
        $job = $command->parseResponse('RESERVED 1244 2048', '{"content":"something"}', $conn);

        $this->assertInstanceOf('BeanstalkJob', $job);
        $this->assertEquals(1244, $job->getId());
    }

    public function testParseResponseOnDeadlineSoon()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::DEADLINE_SOON);

        $command = new BeanstalkCommandReserve();
        $command->parseResponse('DEADLINE_SOON');
    }

    public function testParseResponseOnTimedOut()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::TIMED_OUT);

        $command = new BeanstalkCommandReserve();
        $command->parseResponse('TIMED_OUT');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandReserve();
        $command->parseResponse('This is wack');
    }

}
