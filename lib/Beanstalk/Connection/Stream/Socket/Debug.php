<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


class BeanstalkConnectionStreamSocketDebug extends BeanstalkConnectionStreamSocket
{

    public function open($host, $port)
    {
        $this->_out('OPEN', sprintf('host=%s, port=%s', $host, $port));
        return parent::open($host, $port);
    }

    public function write($data)
    {
        $this->_out('WRITE', $data);
        return parent::write($data);
    }

    public function readLine()
    {
        $ret = parent::readLine();
        $this->_out('READ LINE', $ret);
        return $ret;
    }

    public function read($bytes)
    {
        $ret = parent::read($bytes);
        $this->_out('READ', $ret);
        return $ret;
    }

    protected function _out($title, $text)
    {
        echo "--------------------\n", $title, ":\n", trim($text), "\n";
    }

}
