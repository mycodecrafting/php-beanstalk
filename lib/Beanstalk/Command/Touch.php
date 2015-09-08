<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk\Command;

use Beanstalk\Command;
use Beanstalk\Connection;
use Beanstalk\Exception;

/**
 * Touch command
 *
 * The "touch" command allows a worker to request more time to work on a job.
 * This is useful for jobs that potentially take a long time, but you still want
 * the benefits of a TTR pulling a job away from an unresponsive worker.  A worker
 * may periodically tell the server that it's still alive and processing a job
 * (e.g. it may do this on DEADLINE_SOON).
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class Touch extends Command
{

    protected $id;

    /**
     * Constructor
     *
     * @param integer $id The job id to touch
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('touch %d', $this->id);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param  string                $response Response line, i.e, first line in response
     * @param  string                $data     Data recieved with reponse, if any, else null
     * @param  \Beanstalk\Connection $conn     BeanstalkConnection use to send the command
     * @throws \Beanstalk\Exception  When the job cannot be found or has already timed out
     * @throws \Beanstalk\Exception  When any other error occurs
     * @return boolean               True if command was successful
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
        if ($response === 'TOUCHED') {
            return true;
        }

        if ($response === 'NOT_FOUND') {
            throw new Exception('The job does not exist or is not reserved by the client.', Exception::NOT_FOUND);
        }

        throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }
}
