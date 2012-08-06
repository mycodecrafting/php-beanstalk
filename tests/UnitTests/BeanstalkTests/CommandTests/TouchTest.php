<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\TouchTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandTouch;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/Touch.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testGetCommand()
    {
        $command = new BeanstalkCommandTouch(1098);
        $this->assertEquals('touch 1098', $command->getCommand());

        $command = new BeanstalkCommandTouch('1099');
        $this->assertEquals('touch 1099', $command->getCommand());
    }

    public function testHasNoData()
    {
        $command = new BeanstalkCommandTouch(1098);
        $this->assertFalse($command->getData());
    }

    public function testReturnsNoData()
    {
        $command = new BeanstalkCommandTouch(1098);
        $this->assertFalse($command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $command = new BeanstalkCommandTouch(1098);
        $this->assertTrue($command->parseResponse('TOUCHED'));
    }

    public function testParseResponseOnNotFound()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::NOT_FOUND);

        $command = new BeanstalkCommandTouch(1098);
        $command->parseResponse('NOT_FOUND');
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $command = new BeanstalkCommandTouch(1098);
        $command->parseResponse('This is wack');
    }

}
