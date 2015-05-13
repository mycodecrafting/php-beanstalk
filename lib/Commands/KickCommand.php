<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Beanstalk\Commands;
use \Beanstalk\Command;
use \Beanstalk\Connection;
use \Beanstalk\Exception;

/**
 * Kick command
 *
 * The kick command applies only to the currently used tube. It moves jobs into
 * the ready queue. If there are any buried jobs, it will only kick buried jobs.
 * Otherwise it will kick delayed jobs
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class KickCommand extends Command
{

    protected $_bound;

    /**
     * Constructor
     *
     * @param integer $bound Upper bound on the number of jobs to kick. The server will kick no more than $bound jobs.
     */
    public function __construct($bound)
    {
        $this->_bound = $bound;
    }

    /**
     * Get the delete command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('kick %d', $this->_bound);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data recieved with reponse, if any, else null
     * @param Connection $conn Connection use to send the command
     * @throws Exception When any error occurs
     * @return integer The number of jobs actually kicked
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
		if (preg_match('/^KICKED (.+)$/', $response, $matches))
		{
		    return intval($matches[1]);
		}

	    throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }

}
