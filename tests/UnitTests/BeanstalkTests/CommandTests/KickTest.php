<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\KickTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Kick;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new Kick(5);
        $this->assertEquals('kick 5', $command->getCommand());

        $command = new Kick('25');
        $this->assertEquals('kick 25', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new Kick(5);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new Kick(5);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new Kick(5);
        $this->assertEquals(5, $command->parseResponse('KICKED 5'));
        $this->assertInternalType('integer', $command->parseResponse('KICKED 2'));
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Kick(5);
        $command->parseResponse('This is wack');
    }

}
