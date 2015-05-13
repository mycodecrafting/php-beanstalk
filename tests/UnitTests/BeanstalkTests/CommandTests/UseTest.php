<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\UseTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Commands\UseCommand as BeanstalkCommandUse;
use \Beanstalk\Exception as BeanstalkException;


class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandUse('tube-name');
        $this->assertEquals('use tube-name', $command->getCommand());

        $command = new BeanstalkCommandUse('tube3r');
        $this->assertEquals('use tube3r', $command->getCommand());
    }

    public function testCannotSetTubeNameLongerThan200Bytes()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::TUBE_NAME_TOO_LONG);

        $tube = 'a-long-name-for-a-tube-that-is-completely-ridiculous-and-probably-would-not-happen-in-reality-but-we-have-to-test-for-it-anyways-just-in-case-someone-gets-the-crazy-idea-to-create-a-tube-name-like-this';
        $command = new BeanstalkCommandUse($tube);
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandUse('tube');
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new BeanstalkCommandUse('tube');
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandUse('tube');
        $this->assertEquals('tube', $command->parseResponse('USING tube'));

        $command = new BeanstalkCommandUse('tube2-name');
        $this->assertEquals('tube2-name', $command->parseResponse('USING tube2-name'));
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandUse('tube2-name');
        $command->parseResponse('This is wack');
    }

}
