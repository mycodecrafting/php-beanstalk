<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\JobTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkJob;
use \BeanstalkConnection;

require_once 'PHPUnit/Autoload.php';

require_once dirname(__FILE__) . '/../../../lib/Beanstalk/Job.php';
require_once dirname(__FILE__) . '/../../../lib/Beanstalk/Connection.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->conn = $this->getMock(
            'BeanstalkConnection',
            array('connect', 'delete', 'touch', 'release', 'bury', 'statsJob'),
            array('localhost:11300', $this->getMock('BeanstalkConnectionStream'))
        );
    }

    public function testCanGetJobId()
    {
        $job = new BeanstalkJob($this->conn, 123, '');
        $this->assertEquals(123, $job->getId());

        $job = new BeanstalkJob($this->conn, 789, '');
        $this->assertEquals(789, $job->getId());
    }

    public function testCanGetJobMessage()
    {
        $job = new BeanstalkJob($this->conn, 123, 'Hello World!');
        $this->assertEquals('Hello World!', $job->getMessage());

        $job = new BeanstalkJob($this->conn, 123, 'Another message');
        $this->assertEquals('Another message', $job->getMessage());
    }

    public function testConvertsJsonMessageToObject()
    {
        $job = new BeanstalkJob($this->conn, 123, '{"content":"Hello World!"}');
        $this->assertInstanceOf('stdClass', $job->getMessage());
        $this->assertEquals('Hello World!', $job->getMessage()->content);
    }

    public function testCanGetConnection()
    {
        $job = new BeanstalkJob($this->conn, 123, '{"content":"Hello World!"}');
        $this->assertSame($this->conn, $job->getConnection());
    }

    public function testCanDeleteJob()
    {
        $this->conn->expects($this->once())
                   ->method('delete')
                   ->with($this->equalTo(1122))
                   ->will($this->returnValue(true));

        $job = new BeanstalkJob($this->conn, 1122, '{"content":"Hello World!"}');
        $this->assertTrue($job->delete());
    }

    public function testCanTouchJob()
    {
        $this->conn->expects($this->once())
                   ->method('touch')
                   ->with($this->equalTo(2254))
                   ->will($this->returnValue(true));

        $job = new BeanstalkJob($this->conn, 2254, '{"content":"Hello World!"}');
        $this->assertTrue($job->touch());
    }

    public function testCanReleaseJob()
    {
        $this->conn->expects($this->once())
                   ->method('release')
                   ->with($this->equalTo(3321), $pri = $this->greaterThan(0), $delay = $this->greaterThan(0))
                   ->will($this->returnValue(true));

        $job = new BeanstalkJob($this->conn, 3321, '{"content":"Hello World!"}');
        $this->assertTrue($job->release());
    }

    public function testCanReleaseJobWithDelay()
    {
        $this->conn->expects($this->once())
                   ->method('release')
                   ->with($this->equalTo(3321), $pri = $this->greaterThan(0), $delay = $this->equalTo(120))
                   ->will($this->returnValue(true));

        $job = new BeanstalkJob($this->conn, 3321, '{"content":"Hello World!"}');
        $this->assertTrue($job->release($delay = 120));
    }

    public function testCanReleaseJobWithDelayAndPriority()
    {
        $this->conn->expects($this->once())
                   ->method('release')
                   ->with($this->equalTo(3321), $pri = $this->equalTo(99999), $delay = $this->equalTo(300))
                   ->will($this->returnValue(true));

        $job = new BeanstalkJob($this->conn, 3321, '{"content":"Hello World!"}');
        $this->assertTrue($job->release($delay = 300, $priority = 99999));
    }

    public function testCanBuryJob()
    {
        $this->conn->expects($this->once())
                   ->method('bury')
                   ->with($this->equalTo(8867), $pri = $this->greaterThan(0))
                   ->will($this->returnValue(true));

        $job = new BeanstalkJob($this->conn, 8867, '{"content":"Hello World!"}');
        $this->assertTrue($job->bury());
    }

    public function testCanBuryJobWithPriority()
    {
        $this->conn->expects($this->once())
                   ->method('bury')
                   ->with($this->equalTo(8867), $pri = $this->equalTo(65840))
                   ->will($this->returnValue(true));

        $job = new BeanstalkJob($this->conn, 8867, '{"content":"Hello World!"}');
        $this->assertTrue($job->bury(65840));
    }

    public function testCanGetJobStats()
    {
        $this->conn->expects($this->once())
                   ->method('statsJob')
                   ->with($this->equalTo(1234))
                   ->will($this->returnValue($this->getMock('BeanstalkStats')));

        $job = new BeanstalkJob($this->conn, 1234, '{"content":"Hello World!"}');
        $this->assertInstanceOf('BeanstalkStats', $job->stats());
    }

}
