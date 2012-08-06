<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


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
class BeanstalkCommandReserve extends BeanstalkCommand
{

    protected $_timeout = null;

    /**
     * Constructor
     *
     * @param integer $timeout Wait timeout in seconds
     */
    public function __construct($timeout = null)
    {
        $this->_timeout = $timeout;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        if ($this->_timeout === null)
        {
            return 'reserve';
        }
        else
        {
            return sprintf('reserve-with-timeout %d', $this->_timeout);
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
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data recieved with reponse, if any, else null
     * @param BeanstalkConnection $conn BeanstalkConnection use to send the command
     * @throws BeanstalkException When trying to reserve another job and the TTR of the current job ends soon
     * @throws BeanstalkException When the wait timeout exceeded before a job became available
     * @throws BeanstalkException When any other error occurs
     * @return BeanstalkJob
     */
    public function parseResponse($response, $data = null, BeanstalkConnection $conn = null)
    {
		if (preg_match('/^RESERVED (\d+) (\d+)$/', $response, $matches))
        {
            return new BeanstalkJob($conn, $matches[1], $data);            
        }

        if ($response === 'DEADLINE_SOON')
        {
            throw new BeanstalkException(
                'Reserved job TTR ends soon. Delete or release the job before the server automatically releases it.',
                BeanstalkException::DEADLINE_SOON
            );
        }

        if ($response === 'TIMED_OUT')
        {
            throw new BeanstalkException(
                'The wait timeout exceeded before a job became available', BeanstalkException::TIMED_OUT
            );
        }

	    throw new BeanstalkException('An unknown error has occured.', BeanstalkException::UNKNOWN);
    }

}
