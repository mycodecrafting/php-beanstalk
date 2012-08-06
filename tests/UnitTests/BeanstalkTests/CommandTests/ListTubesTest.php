<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTests\ListTubesTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkCommandListTubes;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Command/ListTubes.php';
require_once dirname(__FILE__) . '/../../../../lib/Beanstalk/Exception.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->command = new BeanstalkCommandListTubes();
    }

    public function testGetCommand()
    {
        $this->assertEquals('list-tubes', $this->command->getCommand());
    }

    public function testHasNoData()
    {
        $this->assertFalse($this->command->getData());
    }

    public function testReturnsData()
    {
        $this->assertTrue($this->command->returnsData());
    }

    public function testParseResponseOnSuccess()
    {
        $this->assertInternalType('array', $this->command->parseResponse('OK 23'));
    }

    public function testParseResponseReturnsArrayOfTubeNames()
    {
        $tubes = $this->command->parseResponse('OK 23', "- tube 1\r\n- tube 2\r\n- tube 3");

        $this->assertEquals(3, count($tubes));
        $this->assertEquals('tube 1', $tubes[0]);
        $this->assertEquals('tube 2', $tubes[1]);
        $this->assertEquals('tube 3', $tubes[2]);

        $tubes = $this->command->parseResponse('OK 245', "- tube-name\r\n- tube-2name\r\n- tube3r");

        $this->assertEquals(3, count($tubes));
        $this->assertEquals('tube-name', $tubes[0]);
        $this->assertEquals('tube-2name', $tubes[1]);
        $this->assertEquals('tube3r', $tubes[2]);
    }

    public function testParseResponseOnOtherErrors()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN);

        $this->command->parseResponse('This is wack');
    }

}
