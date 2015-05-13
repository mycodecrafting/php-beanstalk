<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\StatsTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Stats;

class TestCases extends PHPUnit_Framework_TestCase
{

    public function testCanSetStats()
    {
        $stats = new Stats();
        $stats->setStat('test-stat', '12345');
        $this->assertEquals(12345, $stats->getStat('test-stat'));

        $stats->setStat('another-stat', '263');
        $this->assertEquals(263, $stats->getStat('another-stat'));
    }

    public function testNonSetStatReturnsFalse()
    {
        $stats = new Stats();
        $this->assertFalse($stats->getStat('not-set'));
    }

    public function testGetStatsReturnsArray()
    {
        $stats = new Stats();
        $this->assertInternalType('array', $stats->getStats());
    }

    public function testGetStatsEmptyWhenNoStatsSet()
    {
        $stats = new Stats();
        $this->assertEmpty($stats->getStats());
    }

    public function testGetStatsNotEmptyWhenStatsSet()
    {
        $stats = new Stats();
        $stats->setStat('test-stat', '12345');

        $this->assertNotEmpty($stats->getStats());
    }

    public function testGetStatsReturnsSetStats()
    {
        $stats = new Stats();
        $stats->setStat('test-stat', '12345');
        $stats->setStat('test-stat2', '10098');

        $r = $stats->getStats();
        $this->assertArrayHasKey('test-stat', $r);
        $this->assertArrayHasKey('test-stat2', $r);

        $this->assertEquals('12345', $r['test-stat']);
        $this->assertEquals('10098', $r['test-stat2']);
    }

    public function testCanSetStatsFromInputData()
    {
        $data = 'stat-1: value1' . "\r\n" .
                'another-stat: 123' . "\r\n" .
                'test-stat: 0.554';
        $stats = new Stats($data);

        $this->assertNotEmpty($stats->getStats());
        $this->assertEquals('value1', $stats->getStat('stat-1'));
        $this->assertEquals('123', $stats->getStat('another-stat'));
        $this->assertEquals('0.554', $stats->getStat('test-stat'));
    }

    public function testInvalidInputDataDoesNotSetStats()
    {
        $data = 'stat-1 = value1' . "\r\n" .
                'another-stat = 123' . "\r\n" .
                'test-stat = 0.554';
        $stats = new Stats($data);

        $this->assertEmpty($stats->getStats());
    }

}
