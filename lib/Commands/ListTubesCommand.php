<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Beanstalk\Commands;
use \Beanstalk\Command;
use \Beanstalk\Connection;
use \Beanstalk\Exception;

/**
 * The list-tubes command returns a list of all existing tubes
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class ListTubesCommand extends Command
{

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return 'list-tubes';
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
     * @throws Exception When any error occurs
     * @return array List of all existing tubes
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
		if (preg_match('/^OK (\d+)$/', $response, $matches))
        {
            preg_match_all('/^\-\s+(.+)\r?$/Um', $data, $matches);
            return $matches[1];
        }

	    throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }

}
