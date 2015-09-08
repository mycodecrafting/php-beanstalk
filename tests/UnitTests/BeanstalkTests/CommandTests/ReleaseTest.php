<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\ReleaseTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Release;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new Release(1098, 1024, 5);
        $this->assertEquals('release 1098 1024 5', $command->getCommand());

        $command = new Release(123, 10, 60);
        $this->assertEquals('release 123 10 60', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new Release(1098, 1024, 5);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new Release(1098, 1024, 5);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new Release(1098, 1024, 5);
        $this->assertTrue($command->parseResponse('RELEASED'));
    }

    public function testParseResponseOnBuried()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::BURIED);

        $command = new Release(1098, 1024, 5);
        $command->parseResponse('BURIED');
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_FOUND);

        $command = new Release(1098, 1024, 5);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Release(1098, 1024, 5);
        $command->parseResponse('This is wack');
    }

}
