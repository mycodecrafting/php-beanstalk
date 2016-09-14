<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\KickJobTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\KickJob;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new KickJob(12345);
        $this->assertEquals('kick-job 12345', $command->getCommand());

        $command = new KickJob('98765');
        $this->assertEquals('kick-job 98765', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new KickJob(12345);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new KickJob(12345);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new KickJob(12345);
        $this->assertEquals(true, $command->parseResponse('KICKED'));
        $this->assertInternalType('boolean', $command->parseResponse('KICKED'));
    }

    public function testParseResponseOnNotFoundErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_FOUND);

        $command = new KickJob(12345);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new KickJob(12345);
        $command->parseResponse('This is wack');
    }

}
