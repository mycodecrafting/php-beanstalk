<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * The peek commands let the client inspect a job in the system
 *
 * There are four variations. All but the first operate only on the currently used tube.
 *      - peek $id - return job $id
 *      - ready - return the next ready job
 *      - delayed - return the delayed job with the shortest delay left
 *      - buried - return the next job in the list of buried jobs
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class BeanstalkCommandPeek extends BeanstalkCommand
{

    protected $_what;

    /**
     * Constructor
     *
     * @param mixed $what What to peek. One of job id, "ready", "delayed", or "buried"
     */
    public function __construct($what)
    {
        $this->_what = $what;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        switch ($this->_what)
        {
            case 'ready':
            case 'delayed':
            case 'buried':
                return sprintf('peek-%s', $this->_what);
                break;

            default:
                return sprintf('peek %d', $this->_what);
                break;
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
     * @throws BeanstalkException When the job doesn't exist or there are no jobs in the requested state
     * @throws BeanstalkException When any other error occurs
     * @return BeanstalkJob
     */
    public function parseResponse($response, $data = null, BeanstalkConnection $conn = null)
    {
		if (preg_match('/^FOUND (\d+) (\d+)$/', $response, $matches))
        {
            return new BeanstalkJob($conn, $matches[1], $data);
        }

        if ($response === 'NOT_FOUND')
        {
            throw new BeanstalkException('The requested job doesn\'t exist or there are no jobs in the requested state.', BeanstalkException::NOT_FOUND);
        }

	    throw new BeanstalkException('An unknown error has occured.', BeanstalkException::UNKNOWN);
    }
}
