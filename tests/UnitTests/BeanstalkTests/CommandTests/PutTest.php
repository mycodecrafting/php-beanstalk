<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\PutTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandPut;
use \BeanstalkException;
use \stdClass;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/Put.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommandBasic()
    {
        $command = new BeanstalkCommandPut('Hello World!', 1024, 0, 120);
        $this->assertEquals('put 1024 0 120 12', $command->getCommand());
    }

    public function testGetCommandWithObject()
    {
        $message = new stdClass;
        $message->content = 'Hello World!';
        // json = {"content":"Hello World!"}

        $command = new BeanstalkCommandPut($message, 1024, 0, 120);
        $this->assertEquals('put 1024 0 120 26', $command->getCommand());
    }

    public function testConvertsMessageObjectsToJsonForDataBody()
    {
        $message = new stdClass;
        $message->content = 'Hello World!';
        $command = new BeanstalkCommandPut($message, 1024, 0, 120);

        $this->assertEquals('{"content":"Hello World!"}', $command->getData());

        $message = new stdClass;
        $message->data = 'Hello!';
        $command = new BeanstalkCommandPut($message, 1024, 0, 120);

        $this->assertEquals('{"data":"Hello!"}', $command->getData());
    }

    public function testConvertsPriorityToInteger()
    {
        $command = new BeanstalkCommandPut('Hello', 20.5, 0, 120);
        $this->assertEquals('put 20 0 120 5', $command->getCommand());
    }

    public function testConvertsDelayToInteger()
    {
        $command = new BeanstalkCommandPut('Hello', 1024, 30.5, 120);
        $this->assertEquals('put 1024 30 120 5', $command->getCommand());
    }

    public function testConvertsTtrToInteger()
    {
        $command = new BeanstalkCommandPut('Hello', 1024, 0, 60.5);
        $this->assertEquals('put 1024 0 60 5', $command->getCommand());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandPut('Hello World!', 1024, 0, 120);
        $this->assertEquals(2012, $command->parseResponse('INSERTED 2012'));

        $command = new BeanstalkCommandPut('Hello World!', 1024, 0, 120);
        $this->assertEquals(123, $command->parseResponse('INSERTED 123'));
    }

    public function testParseResponseOnSuccessReturnsInteger()
    {
        $command = new BeanstalkCommandPut('Hello World!', 1024, 0, 120);
        $this->assertInternalType('integer', $command->parseResponse('INSERTED 123'));
    }

    public function testParseResponseOnBuried()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::BURIED);

        $command = new BeanstalkCommandPut('Hello World!', 1024, 0, 120);
        $command->parseResponse('BURIED 234');
    }

    public function testParseResponseOnMissingCrLf()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::EXPECTED_CRLF);

        $command = new BeanstalkCommandPut('Hello World!', 1024, 0, 120);
        $command->parseResponse('EXPECTED_CRLF');
    }

    public function testParseResponseOnJobTooBig()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::JOB_TOO_BIG);

        $command = new BeanstalkCommandPut('Hello World!', 1024, 0, 120);
        $command->parseResponse('JOB_TOO_BIG');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandPut('Hello World!', 1024, 0, 120);
        $command->parseResponse('This is wack');
    }

    public function run(\PHPUnit_Framework_TestResult $result = NULL)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

}
