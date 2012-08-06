<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace UnitTests\BeanstalkTests\ConnectionTest;

use \PHPUnit_Framework_TestCase;
use \BeanstalkConnection;
use \BeanstalkException;

require_once 'PHPUnit/Autoload.php';
require_once dirname(__FILE__) . '/../../../lib/Beanstalk.php';

class TestCases extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->stream = $this->getMockForAbstractClass('BeanstalkConnectionStream');
        $this->conn = new BeanstalkConnection('server:port', $this->stream);
    }

    public function testMustPassInstanceOfBeanstalkConnectionStreamToConstructor()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $conn = new BeanstalkConnection('server:port');
    }

    public function testGetStreamReturnsSetStream()
    {
        $this->assertSame($this->stream, $this->conn->getStream());
    }

    public function testGetServerReturnsAddress()
    {
        $this->assertEquals('server:port', $this->conn->getServer());
    }

    public function testTimedOutStreamTimedOut()
    {
        $this->stream->expects($this->once())
                     ->method('isTimedOut')
                     ->will($this->returnValue(true));
        $this->assertTrue($this->conn->isTimedOut());
    }

    public function testTimedOutStreamNotTimedOut()
    {
        $this->stream->expects($this->once())
                     ->method('isTimedOut')
                     ->will($this->returnValue(false));
        $this->assertFalse($this->conn->isTimedOut());
    }

    public function testCloseStreamClose()
    {
        $this->stream->expects($this->once())
                     ->method('close');
        $this->conn->close();
    }

    public function testPutWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("put 65536 0 120 12\r\nHello World!\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('INSERTED 2012'));

        $this->assertEquals('2012', $this->conn->put('Hello World!'));
    }

    public function testUseTubeWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("use test_tube\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('USING test_tube'));

        $this->assertEquals('test_tube', $this->conn->useTube('test_tube'));
    }

    public function testWatchWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("watch test_tube\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('WATCHING 3'));

        $this->assertEquals(3, $this->conn->watch('test_tube'));
    }

    public function testIgnoreWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("ignore test_tube\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('WATCHING 1'));

        $this->assertEquals(1, $this->conn->ignore('test_tube'));
    }

    public function testReserveWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("reserve\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('RESERVED 1244 2048'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('2048'))
                     ->will($this->returnValue('{"content":"something"}'));

        $this->assertInstanceOf('BeanstalkJob', $this->conn->reserve());
    }

    public function testReserveTimeoutWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("reserve-with-timeout 10\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('RESERVED 1244 2048'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('2048'))
                     ->will($this->returnValue('{"content":"something"}'));

        $this->assertInstanceOf('BeanstalkJob', $this->conn->reserve(10));
    }

    public function testDeleteWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("delete 123\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('DELETED'));

        $this->assertTrue($this->conn->delete('123'));
    }

    public function testTouchWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("touch 123\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('TOUCHED'));

        $this->assertTrue($this->conn->touch('123'));
    }

    public function testReleaseWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("release 123 5 0\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('RELEASED'));

        $this->assertTrue($this->conn->release('123', 5, 0));
    }

    public function testBuryWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("bury 123 5\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('BURIED'));

        $this->assertTrue($this->conn->bury('123', 5));
    }

    public function testKickWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("kick 4\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('KICKED 4'));

        $this->assertEquals(4, $this->conn->kick(4));
    }

    public function testPeekWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("peek 556\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('FOUND 556 2048'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('2048'))
                     ->will($this->returnValue('{"content":"something"}'));

        $this->assertInstanceOf('BeanstalkJob', $this->conn->peek(556));
    }

    public function testPeekReadyWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("peek-ready\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('FOUND 556 2048'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('2048'))
                     ->will($this->returnValue('{"content":"something"}'));

        $this->assertInstanceOf('BeanstalkJob', $this->conn->peekReady());
    }

    public function testPeekDelayedWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("peek-delayed\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('FOUND 556 2048'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('2048'))
                     ->will($this->returnValue('{"content":"something"}'));

        $this->assertInstanceOf('BeanstalkJob', $this->conn->peekDelayed());
    }

    public function testPeekBuriedWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("peek-buried\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('FOUND 556 2048'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('2048'))
                     ->will($this->returnValue('{"content":"something"}'));

        $this->assertInstanceOf('BeanstalkJob', $this->conn->peekBuried());
    }

    public function testStatsWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("stats\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('OK 256'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('256'))
                     ->will($this->returnValue('stat: value'));

        $this->assertInstanceOf('BeanstalkStats', $this->conn->stats());
    }

    public function testStatsTubeWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("stats-tube test_tube\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('OK 256'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('256'))
                     ->will($this->returnValue('stat: value'));

        $this->assertInstanceOf('BeanstalkStats', $this->conn->statsTube('test_tube'));
    }

    public function testListTubesWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("list-tubes\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('OK 256'));

        $this->stream->expects($this->once())
                     ->method('read')
                     ->with($this->equalTo('256'))
                     ->will($this->returnValue("- tube 1\r\n- tube 2\r\n- tube 3"));

        $this->assertInternalType('array', $this->conn->listTubes());
    }

    public function testPauseTubeWritesToStream()
    {
        $this->stream->expects($this->once())
                     ->method('write')
                     ->with($this->equalTo("pause-tube test_tube 30\r\n"));

        $this->stream->expects($this->once())
                     ->method('readLine')
                     ->will($this->returnValue('PAUSED'));

        $this->assertTrue($this->conn->pauseTube('test_tube', 30));
    }

    public function testValidateResponseFalse()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::SERVER_READ);
        $this->conn->validateResponse(false);
    }

    public function testValidateResponseBadFormat()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::BAD_FORMAT);
        $this->conn->validateResponse('BAD_FORMAT');
    }

    public function testValidateResponseOutOfMemory()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::OUT_OF_MEMORY);
        $this->conn->validateResponse('OUT_OF_MEMORY');
    }

    public function testValidateResponseUnknownCommand()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::UNKNOWN_COMMAND);
        $this->conn->validateResponse('UNKNOWN_COMMAND');
    }

    public function testValidateResponseInternalError()
    {
        $this->setExpectedException('BeanstalkException', '', BeanstalkException::INTERNAL_ERROR);
        $this->conn->validateResponse('INTERNAL_ERROR');
    }

    public function testValidateResponseNoError()
    {
        $this->assertTrue($this->conn->validateResponse("OK 256\r\n"));
    }

}
