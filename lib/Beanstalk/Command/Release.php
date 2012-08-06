<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * Release command
 *
 * The release command puts a reserved job back into the ready queue (and marks
 * its state as "ready") to be run by any client. It is normally used when the job
 * fails because of a transitory error.
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class BeanstalkCommandRelease extends BeanstalkCommand
{

    protected $_id = null;
    protected $_priority;
    protected $_delay;

    /**
     * Constructor
     *
     * @param integer $id The job id to release
     * @param integer $priority A new priority to assign to the job
     * @param integer $delay Number of seconds to wait before putting the job in the ready queue. The job will be in the "delayed" state during this time
     */
    public function __construct($id, $priority, $delay)
    {
        $this->_id = $id;
        $this->_priority = $priority;
        $this->_delay = $delay;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('release %d %d %d', $this->_id, $this->_priority, $this->_delay);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data recieved with reponse, if any, else null
     * @param BeanstalkConnection $conn BeanstalkConnection use to send the command
     * @throws BeanstalkException When the server runs out of memory
     * @throws BeanstalkException When the job cannot be found or has already timed out
     * @throws BeanstalkException When any other error occurs
     * @return boolean True if command was successful
     */
    public function parseResponse($response, $data = null, BeanstalkConnection $conn = null)
    {
        if ($response === 'RELEASED')
        {
            return true;
        }

        if ($response === 'BURIED')
        {
            throw new BeanstalkException(
                'The server ran out of memory trying to grow the priority queue data structure.', BeanstalkException::BURIED
            );
        }

        if ($response === 'NOT_FOUND')
        {
		    throw new BeanstalkException(
		        'The job does not exist or is not reserved by the client.', BeanstalkException::NOT_FOUND
		    );
        }

	    throw new BeanstalkException('An unknown error has occured.', BeanstalkException::UNKNOWN);
    }

}
