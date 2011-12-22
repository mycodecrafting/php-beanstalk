<?php
/* $Id$ */
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

    public function run(\PHPUnit_Framework_TestResult $result = NULL)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

}
