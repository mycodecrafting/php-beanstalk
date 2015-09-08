<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\TouchTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Touch;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new Touch(1098);
        $this->assertEquals('touch 1098', $command->getCommand());

        $command = new Touch('1099');
        $this->assertEquals('touch 1099', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new Touch(1098);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new Touch(1098);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new Touch(1098);
        $this->assertTrue($command->parseResponse('TOUCHED'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_FOUND);

        $command = new Touch(1098);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Touch(1098);
        $command->parseResponse('This is wack');
    }

}
