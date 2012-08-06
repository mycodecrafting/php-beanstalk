<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk;

require_once 'PHPUnit/Autoload.php';
require_once dirname(__FILE__) . '/../../lib/Beanstalk.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testInitReturnsBeanstalkPoolInstance()
    {
        $this->assertInstanceOf('BeanstalkPool', Beanstalk::init());
    }

    public function testInitAlwaysReturnsSameInstanceOfBeanstalkPool()
    {
        $this->assertSame(Beanstalk::init(), Beanstalk::init());
    }

    public function testAutoloadSkipsUnrelatedClassNames()
    {
        $this->assertFalse(Beanstalk::autoload('NotBeanstalk'));
    }

    public function testAutoloadCoreClasses()
    {
        Beanstalk::autoload('BeanstalkCommand');
        $this->assertTrue(class_exists('BeanstalkCommand', false));
    }

    public function testAutoloadCommandClasses()
    {
        Beanstalk::autoload('BeanstalkCommandPut');
        $this->assertTrue(class_exists('BeanstalkCommandPut', false));
    }

}
