<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk\Connection\Stream;

use Beanstalk\Connection\Stream;

/**
 * Connection stream using PHP native sockets
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class Socket implements Stream
{

    protected $socket;

    /**
     * Open the stream
     *
     * @param  string  $host    Host or IP address to connect to
     * @param  integer $port    Port to connect on
     * @param  float   $timeout Connection timeout in milliseconds
     * @return boolean
     */
    public function open($host, $port, $timeout)
    {
        if (($this->socket = @fsockopen($host, $port, $errno, $errstr, ($timeout / 1000))) === false) {
            return false;
        }

        return true;
    }

    /**
     * Has the connection timed out or otherwise gone away?
     *
     * @return boolean
     */
    public function isTimedOut()
    {
        if (is_resource($this->socket)) {
            $info = stream_get_meta_data($this->socket);
        }

        return $this->socket === null || $this->socket === false || $info['timed_out'] || feof($this->socket);
    }

    /**
     * Write data to the stream
     *
     * @param  string  $data
     * @return integer Number of bytes written
     */
    public function write($data)
    {
        for ($written = 0, $fwrite = 0; $written < strlen($data); $written += $fwrite) {
            $fwrite = fwrite($this->socket, substr($data, $written));
            if ($fwrite === false || ($fwrite === 0 && feof($this->socket))) {
                // broken pipe!
                if ($fwrite === 0 && feof($this->socket)) {
                    $this->close();
                }

                return false;
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
        do {
            $line = rtrim(fgets($this->socket));

            // server must have dropped the connection
            if ($line === '' && feof($this->socket)) {
                $this->close();

                return false;
            }
        } while ($line === '');

        return $line;
    }

    /**
     * Read the next $bytes bytes from the stream
     *
     * @param  integer $bytes Number of bytes to read
     * @return string
     */
    public function read($bytes)
    {
        $read = 0;
        $parts = array();

        while ($read < $bytes) {
            $data = fread($this->socket, $bytes - $read);

            if ($data === false) {
                // server must have dropped the connection
                if (feof($this->socket)) {
                    $this->close();
                }

                return false;
            }

            $read += strlen($data);
            $parts[] = $data;
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
        @fclose($this->socket);
        $this->socket = null;
    }
}
