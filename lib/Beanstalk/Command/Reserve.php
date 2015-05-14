<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk\Command;

use Beanstalk\Command;
use Beanstalk\Connection;
use Beanstalk\Exception;
use Beanstalk\Job;

/**
 * Reserve command
 *
 * This will return a newly-reserved job. If no job is available to be reserved,
 * beanstalkd will wait to send a response until one becomes available. Once a
 * job is reserved for the client, the client has limited time to run (TTR) the
 * job before the job times out. When the job times out, the server will put the
 * job back into the ready queue. Both the TTR and the actual time left can be
 * found in response to the stats-job command.
 *
 * A timeout value of 0 will cause the server to immediately return either a
 * response or TIMED_OUT.  A positive value of timeout will limit the amount of
 * time the client will block on the reserve request until a job becomes
 * available.
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class Reserve extends Command
{

    protected $timeout = null;

    /**
     * Constructor
     *
     * @param integer $timeout Wait timeout in seconds
     */
    public function __construct($timeout = null)
    {
        $this->timeout = $timeout;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        if ($this->timeout === null) {
            return 'reserve';
        } else {
            return sprintf('reserve-with-timeout %d', $this->timeout);
        }
    }

    /**
     * Does the command return data?
     *
     * @return boolean
     */
    public function returnsData()
    {
        return true;
    }

    /**
     * Parse the response for success or failure.
     *
     * @param  string                $response Response line, i.e, first line in response
     * @param  string                $data     Data recieved with reponse, if any, else null
     * @param  \Beanstalk\Connection $conn     BeanstalkConnection use to send the command
     * @throws \Beanstalk\Exception  When trying to reserve another job and the TTR of the current job ends soon
     * @throws \Beanstalk\Exception  When the wait timeout exceeded before a job became available
     * @throws \Beanstalk\Exception  When any other error occurs
     * @return \Beanstalk\Job
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
        if (preg_match('/^RESERVED (\d+) (\d+)$/', $response, $matches)) {
            return new Job($conn, $matches[1], $data);
        }

        if ($response === 'DEADLINE_SOON') {
            throw new Exception(
                'Reserved job TTR ends soon. Delete or release the job before the server automatically releases it.',
                Exception::DEADLINE_SOON
            );
        }

        if ($response === 'TIMED_OUT') {
            throw new Exception(
                'The wait timeout exceeded before a job became available',
                Exception::TIMED_OUT
            );
        }

        throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }
}
