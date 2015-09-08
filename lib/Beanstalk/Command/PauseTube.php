<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk\Command;

use Beanstalk\Command;
use Beanstalk\Connection;
use Beanstalk\Exception;

/**
 * The pause-tube command can delay any new job being reserved for a given time
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class PauseTube extends Command
{

    protected $tube;
    protected $delay;

    /**
     * Constructor
     *
     * @param string  $tube  The tube to pause
     * @param integer $delay Number of seconds to wait before reserving any more jobs from the queue
     */
    public function __construct($tube, $delay)
    {
        $this->tube = $tube;
        $this->delay = $delay;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('pause-tube %s %d', $this->tube, $this->delay);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param  string              $response Response line, i.e, first line in response
     * @param  string              $data     Data recieved with reponse, if any, else null
     * @param  \Beanstalk\Connection $conn     BeanstalkConnection use to send the command
     * @throws \Beanstalk\Exception  When the tube does not exist
     * @throws \Beanstalk\Exception  When any other error occurs
     * @return boolean             True if command was successful
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
        if ($response === 'PAUSED') {
            return true;
        }

        if ($response === 'NOT_FOUND') {
            throw new Exception('The tube does not exist.', Exception::NOT_FOUND);
        }

        throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }
}
