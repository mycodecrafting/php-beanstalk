<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Beanstalk\Commands;
use \Beanstalk\Command;
use \Beanstalk\Connection;
use \Beanstalk\Exception;

/**
 * Ignore command
 *
 * The "ignore" command is for consumers. It removes the named tube from the
 * watch list for the current connection.
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class IgnoreCommand extends Command
{

    protected $_tube;

    /**
     * Constructor
     *
     * @param string $tube Tube to remove from the watch list
     */
    public function __construct($tube)
    {
        $this->_tube = $tube;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('ignore %s', $this->_tube);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data received with reponse, if any, else null
     * @param Connection $conn Connection use to send the command
     * @throws Exception When the requested tube cannot be ignored
     * @throws Exception When any error occurs
     * @return integer The number of tubes being watched
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
		if (preg_match('/^WATCHING (.+)$/', $response, $matches))
		{
		    return intval($matches[1]);
		}

        if ($response === 'NOT_IGNORED')
        {
            throw new Exception('Cannot ignore the only tube in the watch list', Exception::NOT_IGNORED);
        }

	    throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }

}
