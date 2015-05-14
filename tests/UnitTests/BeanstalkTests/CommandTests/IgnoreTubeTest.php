<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\IgnoreTubeTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\IgnoreTube;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new IgnoreTube('tube-name');
        $this->assertEquals('ignore tube-name', $command->getCommand());

        $command = new IgnoreTube('tube3r');
        $this->assertEquals('ignore tube3r', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new IgnoreTube('tube');
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new IgnoreTube('tube');
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new IgnoreTube('tube');
        $this->assertEquals(1, $command->parseResponse('WATCHING 1'));

        $this->assertEquals(5, $command->parseResponse('WATCHING 5'));
    }

    public function testParseResponseOnSuccessReturnInteger()
    {
        $command = new IgnoreTube('tube');
        $this->assertInternalType('integer', $command->parseResponse('WATCHING 3'));
    }

    public function testParseResponseOnNotIgnored()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_IGNORED);

        $command = new IgnoreTube('tube');
        $command->parseResponse('NOT_IGNORED');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new IgnoreTube('tube');
        $command->parseResponse('This is wack');
    }

}
