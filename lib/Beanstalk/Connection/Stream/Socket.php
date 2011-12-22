<?php
/* $Id$ */
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * Connection stream using PHP native sockets
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class BeanstalkConnectionStreamSocket implements BeanstalkConnectionStream
{

    protected $_socket;

    /**
     * Open the stream
     *
     * @param string $host Host or IP address to connect to
     * @param integer $port Port to connect on
     * @return boolean
     */
    public function open($host, $port)
    {
        if (($this->_socket = @fsockopen($host, $port, $errno, $errstr)) === false)
        {
            return false;
        }

        return true;
    }

    /**
     * Has the connection timed out?
     *
     * @return boolean
     */
    public function isTimedOut()
    {
        $info = stream_get_meta_data($this->_socket);
        return $info['timed_out'];
    }

    /**
     * Write data to the stream
     *
     * @param string $data
     * @return integer Number of bytes written
     */
    public function write($data)
    {
        for ($written = 0, $fwrite = 0; $written < strlen($data); $written += $fwrite)
        {
            $fwrite = fwrite($this->_socket, substr($data, $written));
            if ($fwrite === false)
            {
                return $written;
            }
        }

        return $written;
    }

    /**
     * Read the next line from the stream
     *
     * @return string
     */
    public function readLine()
    {
        do
        {
            $line = rtrim(fgets($this->_socket));            
        }
        while ($line === '');
        return $line;
    }

    /**
     * Read the next $bytes bytes from the stream
     *
     * @param integer $bytes Number of bytes to read
     * @return string
     */
    public function read($bytes)
    {
		$read = 0;
		$parts = array();

		while ($read < $bytes && !feof($this->_socket))
		{
			$data = fread($this->_socket, $bytes - $read);

			if ($data === false)
			{
                return false;
			}

			$read += strlen($data);
			$parts []= $data;
		}

		return implode($parts);
    }

    /**
     * Close the stream connection
     *
     * @return void
     */
    public function close()
    {
        fclose($this->_socket);
        $this->_socket = null;
    }

}
