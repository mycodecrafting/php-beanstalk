<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\BuryTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Bury;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new Bury(150, 1024);
        $this->assertEquals('bury 150 1024', $command->getCommand());

        $command = new Bury('365', '5');
        $this->assertEquals('bury 365 5', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new Bury(1, 2);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new Bury(1, 2);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new Bury(1, 2);
        $this->assertTrue($command->parseResponse('BURIED'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_FOUND);

        $command = new Bury(1, 2);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Bury(1, 2);
        $command->parseResponse('This is wack');
    }

}
