<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\CommandTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Command;

class TestCases extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->command = $this->getMockForAbstractClass('\\Beanstalk\\Command');
    }

    public function testDefaultsToNotHavingData()
    {
        $this->assertFalse($this->command->getData());
    }

    public function testDefaultsToNotReturningData()
    {
        $this->assertFalse($this->command->returnsData());
    }

}
