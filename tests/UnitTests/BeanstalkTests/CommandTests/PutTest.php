<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\PutTest;

use PHPUnit_Framework_TestCase;
use Beanstalk\Command\Put;
use stdClass;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommandBasic()
    {
        $command = new Put('Hello World!', 1024, 0, 120);
        $this->assertEquals('put 1024 0 120 12', $command->getCommand());
    }

    public function testGetCommandWithObject()
    {
        $message = new stdClass;
        $message->content = 'Hello World!';
        // json = {"content":"Hello World!"}

        $command = new Put($message, 1024, 0, 120);
        $this->assertEquals('put 1024 0 120 26', $command->getCommand());
    }

    public function testConvertsMessageObjectsToJsonForDataBody()
    {
        $message = new stdClass;
        $message->content = 'Hello World!';
        $command = new Put($message, 1024, 0, 120);

        $this->assertEquals('{"content":"Hello World!"}', $command->getData());

        $message = new stdClass;
        $message->data = 'Hello!';
        $command = new Put($message, 1024, 0, 120);

        $this->assertEquals('{"data":"Hello!"}', $command->getData());
    }

    public function testConvertsPriorityToInteger()
    {
        $command = new Put('Hello', 20.5, 0, 120);
        $this->assertEquals('put 20 0 120 5', $command->getCommand());
    }

    public function testConvertsDelayToInteger()
    {
        $command = new Put('Hello', 1024, 30.5, 120);
        $this->assertEquals('put 1024 30 120 5', $command->getCommand());
    }

    public function testConvertsTtrToInteger()
    {
        $command = new Put('Hello', 1024, 0, 60.5);
        $this->assertEquals('put 1024 0 60 5', $command->getCommand());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new Put('Hello World!', 1024, 0, 120);
        $this->assertEquals(2012, $command->parseResponse('INSERTED 2012'));

        $command = new Put('Hello World!', 1024, 0, 120);
        $this->assertEquals(123, $command->parseResponse('INSERTED 123'));
    }

    public function testParseResponseOnSuccessReturnsInteger()
    {
        $command = new Put('Hello World!', 1024, 0, 120);
        $this->assertInternalType('integer', $command->parseResponse('INSERTED 123'));
    }

    public function testParseResponseOnBuried()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::BURIED);

        $command = new Put('Hello World!', 1024, 0, 120);
        $command->parseResponse('BURIED 234');
    }

    public function testParseResponseOnMissingCrLf()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::EXPECTED_CRLF);

        $command = new Put('Hello World!', 1024, 0, 120);
        $command->parseResponse('EXPECTED_CRLF');
    }

    public function testParseResponseOnJobTooBig()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::JOB_TOO_BIG);

        $command = new Put('Hello World!', 1024, 0, 120);
        $command->parseResponse('JOB_TOO_BIG');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('\Beanstalk\Exception', '', \Beanstalk\Exception::UNKNOWN);

        $command = new Put('Hello World!', 1024, 0, 120);
        $command->parseResponse('This is wack');
    }

}
