<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\StatsTubeTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Commands\StatsTubeCommand as BeanstalkCommandStatsTube;
use \Beanstalk\Exception as BeanstalkException;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandStatsTube('tube-name');
        $this->assertEquals('stats-tube tube-name', $command->getCommand());
    }

    public function testCannotSetTubeNameLongerThan200Bytes()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::TUBE_NAME_TOO_LONG);

        $tube = 'a-long-name-for-a-tube-that-is-completely-ridiculous-and-probably-would-not-happen-in-reality-but-we-have-to-test-for-it-anyways-just-in-case-someone-gets-the-crazy-idea-to-create-a-tube-name-like-this';
        $command = new BeanstalkCommandStatsTube($tube);
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandStatsTube('tube-name');
        $this->assertFalse($command->getData());
    }

    public function testReturnsData()
    {
        $command = new BeanstalkCommandStatsTube('tube-name');
        $this->assertTrue($command->returnsData());
    }

    public function testParseResponseOnSuccessReturnsBeanstalkStats()
    {
        $command = new BeanstalkCommandStatsTube('tube-name');
        $this->assertInstanceOf('\\Beanstalk\\Stats', $command->parseResponse('OK 256'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::NOT_FOUND);

        $command = new BeanstalkCommandStatsTube('tube-name');
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnError()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandStatsTube('tube-name');
        $command->parseResponse('This is wack');
    }

}
