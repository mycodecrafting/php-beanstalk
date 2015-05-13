<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Beanstalk;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testInitReturnsBeanstalkPoolInstance()
    {
        $this->assertInstanceOf('\\Beanstalk\\Pool', Beanstalk::init());
    }

    public function testInitAlwaysReturnsSameInstanceOfBeanstalkPool()
    {
        $this->assertSame(Beanstalk::init(), Beanstalk::init());
    }

    /**
     * Deprecated autoload tests
     */

}
