<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\KickTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Commands\KickCommand as BeanstalkCommandKick;
use \Beanstalk\Exception as BeanstalkException;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandKick(5);
        $this->assertEquals('kick 5', $command->getCommand());

        $command = new BeanstalkCommandKick('25');
        $this->assertEquals('kick 25', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandKick(5);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new BeanstalkCommandKick(5);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandKick(5);
        $this->assertEquals(5, $command->parseResponse('KICKED 5'));
        $this->assertInternalType('integer', $command->parseResponse('KICKED 2'));
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandKick(5);
        $command->parseResponse('This is wack');
    }

}
