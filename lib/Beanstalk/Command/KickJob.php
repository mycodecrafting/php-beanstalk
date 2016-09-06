<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk\Command;

use Beanstalk\Command;
use Beanstalk\Connection;
use Beanstalk\Exception;

/**
 * Kick-job command
 *
 * The kick-job command is a variant of kick that operates with a single job identified by its
 * job id. If the given job id exists and is in a buried or delayed state, it will be moved to
 * the ready queue of the the same tube where it currently belongs.
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class KickJob extends Command
{

    protected $id;

    /**
     * Constructor
     *
     * @param integer $id The job id to kick.
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
        return sprintf('kick-job %d', $this->id);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param  string                $response Response line, i.e, first line in response
     * @param  string                $data     Data recieved with reponse, if any, else null
     * @param  \Beanstalk\Connection $conn     BeanstalkConnection use to send the command
     * @throws \Beanstalk\Exception  When the job cannot be found or is not in a kickable state.
     * @throws \Beanstalk\Exception  When any other error occurs
     * @return boolean               True if command was successful
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
        if ($response === 'KICKED') {
            return true;
        }

        if ($response === 'NOT_FOUND') {
            throw new Exception('The job does not exist or is not in a kickable state..', Exception::NOT_FOUND);
        }

        throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }
}
