<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\StatsTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkStats;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../lib/Beanstalk/Stats.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testCanSetStats()
    {
        $stats = new BeanstalkStats();
        $stats->setStat('test-stat', 12345);
        $this->assertEquals(12345, $stats->getStat('test-stat'));

        $stats->setStat('another-stat', 263);
        $this->assertEquals(263, $stats->getStat('another-stat'));
    }

    public function run(\PHPUnit_Framework_TestResult $result = NULL)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

}
