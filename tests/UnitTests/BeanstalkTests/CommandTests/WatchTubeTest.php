<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\WatchTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\WatchTube;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new WatchTube('tube-name');
        $this->assertEquals('watch tube-name', $command->getCommand());

        $command = new WatchTube('tube3r');
        $this->assertEquals('watch tube3r', $command->getCommand());
    }

    public function testCannotSetTubeNameLongerThan200Bytes()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::TUBE_NAME_TOO_LONG);

        $tube = 'a-long-name-for-a-tube-that-is-completely-ridiculous-and-probably-would-not-happen-in-reality-but-we-have-to-test-for-it-anyways-just-in-case-someone-gets-the-crazy-idea-to-create-a-tube-name-like-this';
        $command = new WatchTube($tube);
    }

    public function testHasNoData()
    {
        $command = new WatchTube('tube');
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new WatchTube('tube');
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new WatchTube('tube');
        $this->assertEquals(2, $command->parseResponse('WATCHING 2'));

        $command = new WatchTube('tube2-name');
        $this->assertEquals(3, $command->parseResponse('WATCHING 3'));
    }

    public function testParseResponseOnSuccessReturnInteger()
    {
        $command = new WatchTube('tube');
        $this->assertInternalType('integer', $command->parseResponse('WATCHING 3'));
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new WatchTube('tube');
        $command->parseResponse('This is wack');
    }

}
