<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\IgnoreTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Commands\IgnoreCommand as BeanstalkCommandIgnore;
use \Beanstalk\Exception as BeanstalkException;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandIgnore('tube-name');
        $this->assertEquals('ignore tube-name', $command->getCommand());

        $command = new BeanstalkCommandIgnore('tube3r');
        $this->assertEquals('ignore tube3r', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandIgnore('tube');
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new BeanstalkCommandIgnore('tube');
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandIgnore('tube');
        $this->assertEquals(1, $command->parseResponse('WATCHING 1'));

        $this->assertEquals(5, $command->parseResponse('WATCHING 5'));
    }

    public function testParseResponseOnSuccessReturnInteger()
    {
        $command = new BeanstalkCommandIgnore('tube');
        $this->assertInternalType('integer', $command->parseResponse('WATCHING 3'));
    }

    public function testParseResponseOnNotIgnored()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::NOT_IGNORED);

        $command = new BeanstalkCommandIgnore('tube');
        $command->parseResponse('NOT_IGNORED');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandIgnore('tube');
        $command->parseResponse('This is wack');
    }

}
