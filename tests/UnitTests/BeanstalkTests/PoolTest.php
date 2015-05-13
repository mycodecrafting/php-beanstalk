<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\PoolTest;

use \PHPUnit_Framework_TestCase;
use \Beanstalk\Pool;

class TestCases extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->pool = new Pool();
    }

    public function testHasNoServersByDefault()
    {
        $this->assertInternalType('array', $this->pool->getServers());
        $this->assertEmpty($this->pool->getServers());
    }

    public function testCanAddAServer()
    {
        $this->pool->addServer('hostname', 11303);
        $servers = $this->pool->getServers();
        $this->assertEquals(1, count($servers));
        $this->assertEquals('hostname:11303', $servers[0]);
    }

    public function testAddServerDefaultsToPort11300()
    {
        $this->pool->addServer('host');
        $servers = $this->pool->getServers();
        $this->assertEquals('host:11300', $servers[0]);
    }

    public function testCanAddMultipleServers()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2', 11301);
        $this->pool->addServer('server3');

        $servers = $this->pool->getServers();
        $this->assertEquals(3, count($servers));
        $this->assertEquals('server1:11300', $servers[0]);
        $this->assertEquals('server2:11301', $servers[1]);
        $this->assertEquals('server3:11300', $servers[2]);
    }

    public function testGetLastConnectionsReturnsFalseWhenNone()
    {
        $this->assertFalse($this->pool->getLastConnection());
    }

    public function testConnectThrowsExceptionWhenAllServersOffline()
    {
        $this->setExpectedException('\\Beanstalk\\Exception', 'Unknown: Could not establish a connection to any beanstalkd server in the pool.');

        $this->pool->addServer('server1');
        $this->pool->addServer('server2');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamOffline');
        $this->pool->connect();
    }

    public function testGetConnectionsEmptyWhenAllServersOffline()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamOffline');
        $conns = $this->pool->getConnections();

        $this->assertInternalType('array', $conns);
        $this->assertEmpty($conns);
    }

    public function testCanGetConnectionsWhenServersOnline()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamOnline');
        $conns = $this->pool->getConnections();

        $this->assertNotEmpty($conns);
        $this->assertEquals(2, count($conns));
    }

    public function testPutSendsToSingleRandomConnection()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamPutWriteCount');
        $this->pool->put('Hello World!');

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(1, $count);
    }

    public function testGetLastConnectionsReturnsConnAfterPut()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamPutWriteCount');
        $this->pool->put('Hello World!');

        $this->assertInstanceOf('\\Beanstalk\\Connection', $this->pool->getLastConnection());
    }

    public function testUseSendsToAllConnections()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamUseWriteCount');
        $this->pool->useTube('test_tube');

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(3, $count);
    }

    public function testWatchSendsToAllConnections()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamWatchWriteCount');
        $this->pool->watchTube('test_tube');

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(3, $count);
    }

    public function testIgnoreSendsToAllConnections()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamWatchWriteCount');
        $this->pool->ignoreTube('test_tube');

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(3, $count);
    }

    public function testReserveSendsToSingleRandomConnection()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamReserveWriteCount');
        $this->pool->reserve();

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(1, $count);
    }

    public function testStatsSendsToAllConnections()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamStatsWriteCount');
        $this->pool->stats();

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(3, $count);
    }

    public function testListTubesSendsToAllConnections()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamListTubesWriteCount');
        $this->pool->listTubes();

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(3, $count);
    }

    public function testPauseTubeSendsToAllConnections()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamPauseWriteCount');
        $this->pool->pauseTube('test_tube', 30);

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(3, $count);
    }

    public function testPauseTubeReturnsTrue()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamPauseWriteCount');
        $this->assertTrue($this->pool->pauseTube('test_tube', 30));
    }

    public function testKickSendsToAllConnections()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamKickWriteCount');
        $this->pool->kick(5);

        $conns = $this->pool->getConnections();
        $count = 0;
        foreach ($conns as $conn)
        {
            $count += $conn->getStream()->getWrites();
        }

        $this->assertEquals(3, $count);
    }

    public function testKickReturnsSumOfKicked()
    {
        $this->pool->addServer('server1');
        $this->pool->addServer('server2');
        $this->pool->addServer('server3');

        $this->pool->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamKickWriteCount');
        $this->assertEquals(15, $this->pool->kick(5));
    }

    public function testTimeoutDefaultsTo500ms()
    {
        $this->assertEquals(500, $this->pool->getTimeout());
    }

    public function testCanAlterDefaultTimeout()
    {
        $this->pool->setTimeout(10);
        $this->assertEquals(10, $this->pool->getTimeout());
    }

    public function testSetTimeoutIsAFloat()
    {
        $this->pool->setTimeout('100');
        $this->assertInternalType('float', $this->pool->getTimeout());
    }

    public function testSetsTimeoutInConnection()
    {
        $this->pool->addServer('server1')
                   ->addServer('server2')
                   ->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamOnline')
                   ->setTimeout(10);

        foreach ($this->pool->getConnections() as $conn)
        {
            $this->assertEquals(10, $conn->getTimeout());
        }
    }

    /**
     * Tests for fluid interface:
     *      $pool->addServer('server1')
     *           ->addServer('server2')
     *           ->addServer('server3')
     *           ->addServer('server4')
     *           ->setStream('CustomStreamClass')
     *           ->setTimeout(10)
     *           ->useTube('my_tube')
     *           ->watchTube('tube_name')
     *           ->ignoreTube('other_tube');
     */

    public function testAddServerReturnsSelf()
    {
        $this->assertSame($this->pool, $this->pool->addServer('server1'));
    }

    public function testSetStreamReturnsSelf()
    {
        $this->assertSame($this->pool, $this->pool->setStream('CustomStreamClass'));
    }

    public function testSetTimeoutReturnsSelf()
    {
        $this->assertSame($this->pool, $this->pool->setTimeout(10));
    }

    public function testUseTubeReturnsSelf()
    {
        $this->pool->addServer('server1')
                   ->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamUseWriteCount');
        $this->assertSame($this->pool, $this->pool->useTube('my_tube'));
    }

    public function testWatchTubeReturnsSelf()
    {
        $this->pool->addServer('server1')
                   ->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamWatchWriteCount');
        $this->assertSame($this->pool, $this->pool->watchTube('my_tube'));
    }

    public function testIgnoreTubeReturnsSelf()
    {
        $this->pool->addServer('server1')
                   ->setStream('UnitTests\BeanstalkTests\PoolTest\TestBeanstalkConnectionStreamWatchWriteCount');
        $this->assertSame($this->pool, $this->pool->ignoreTube('other_tube'));
    }

}

class TestBeanstalkConnectionStreamOffline implements \Beanstalk\Connections\Stream
{

    public function open($host, $port, $timeout)
    {
        return false;
    }

    public function isTimedOut()
    {
        return false;
    }

    public function write($data)
    {
        return 1;
    }

    public function readLine()
    {
        return '';
    }

    public function read($bytes)
    {
        return '';
    }

    public function close()
    {
    }

}

class TestBeanstalkConnectionStreamOnline implements \Beanstalk\Connections\Stream
{

    public function open($host, $port, $timeout)
    {
        return true;
    }

    public function isTimedOut()
    {
        return false;
    }

    public function write($data)
    {
        return 1;
    }

    public function readLine()
    {
        return '';
    }

    public function read($bytes)
    {
        return '';
    }

    public function close()
    {
    }

}

class TestBeanstalkConnectionStreamWriteCount extends TestBeanstalkConnectionStreamOnline
{
    protected $_writes = 0;
    public function write($data)
    {
        ++$this->_writes;
        return 1;
    }

    public function getWrites()
    {
        return $this->_writes;
    }
}

class TestBeanstalkConnectionStreamPutWriteCount extends TestBeanstalkConnectionStreamWriteCount
{
    public function readLine()
    {
        return 'INSERTED 2012';
    }
}

class TestBeanstalkConnectionStreamUseWriteCount extends TestBeanstalkConnectionStreamWriteCount
{
    public function readLine()
    {
        return 'USING test_tube';
    }
}

class TestBeanstalkConnectionStreamWatchWriteCount extends TestBeanstalkConnectionStreamWriteCount
{
    public function readLine()
    {
        return 'WATCHING 1';
    }
}

class TestBeanstalkConnectionStreamReserveWriteCount extends TestBeanstalkConnectionStreamWriteCount
{
    public function readLine()
    {
        return 'RESERVED 1244 2048';
    }

    public function read($bytes)
    {
        return '{"content":"something"}';
    }
}

class TestBeanstalkConnectionStreamStatsWriteCount extends TestBeanstalkConnectionStreamWriteCount
{
    public function readLine()
    {
        return 'OK 256';
    }

    public function read($bytes)
    {
        return 'stat: value';
    }
}

class TestBeanstalkConnectionStreamListTubesWriteCount extends TestBeanstalkConnectionStreamWriteCount
{
    public function readLine()
    {
        return 'OK 256';
    }

    public function read($bytes)
    {
        return "- tube 1\r\n- tube 2\r\n- tube 3";
    }
}

class TestBeanstalkConnectionStreamPauseWriteCount extends TestBeanstalkConnectionStreamWriteCount
{
    public function readLine()
    {
        return 'PAUSED';
    }
}

class TestBeanstalkConnectionStreamKickWriteCount extends TestBeanstalkConnectionStreamWriteCount
{
    public function readLine()
    {
        return 'KICKED 5';
    }
}
