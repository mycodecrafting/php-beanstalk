<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Beanstalk\Commands;
use \Beanstalk\Command;
use \Beanstalk\Connection;
use \Beanstalk\Job;
use \Beanstalk\Exception;

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
class PeekCommand extends Command
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
     * @param Connection $conn Connection use to send the command
     * @throws Exception When the job doesn't exist or there are no jobs in the requested state
     * @throws Exception When any other error occurs
     * @return BeanstalkJob
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
		if (preg_match('/^FOUND (\d+) (\d+)$/', $response, $matches))
        {
            return new Job($conn, $matches[1], $data);
        }

        if ($response === 'NOT_FOUND')
        {
            throw new Exception('The requested job doesn\'t exist or there are no jobs in the requested state.', Exception::NOT_FOUND);
        }

	    throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }
}
