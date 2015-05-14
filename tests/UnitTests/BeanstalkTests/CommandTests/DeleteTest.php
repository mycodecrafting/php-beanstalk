<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\DeleteTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Delete;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new Delete(1098);
        $this->assertEquals('delete 1098', $command->getCommand());

        $command = new Delete('1099');
        $this->assertEquals('delete 1099', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new Delete(1098);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new Delete(1098);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new Delete(1098);
        $this->assertTrue($command->parseResponse('DELETED'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::NOT_FOUND);

        $command = new Delete(1098);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Delete(1098);
        $command->parseResponse('This is wack');
    }

}
