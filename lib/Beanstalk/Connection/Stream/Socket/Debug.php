<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk\Connection\Stream\Socket;

use Beanstalk\Connection\Stream\Socket;

class Debug extends Socket
{

    public function open($host, $port, $timeout)
    {
        $this->out('OPEN', sprintf('host=%s, port=%s, timeout=%sms', $host, $port, $timeout));

        return parent::open($host, $port, $timeout);
    }

    public function write($data)
    {
        $this->out('WRITE', $data);

        return parent::write($data);
    }

    public function readLine()
    {
        $this->out('DEBUG', 'Attempting to read the next line');
        $ret = parent::readLine();
        $this->out('READ LINE', $ret);

        return $ret;
    }

    public function read($bytes)
    {
        $ret = parent::read($bytes);
        $this->out('READ', $ret);

        return $ret;
    }

    protected function out($title, $text)
    {
        echo "--------------------\n", $title, ":\n", trim($text), "\n";
    }
}
