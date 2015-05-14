<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk\Command;

use Beanstalk\Command;
use Beanstalk\Connection;
use Beanstalk\Exception;
use Beanstalk\Stats as BeanstalkStats;

/**
 * The stats command gives statistical information about the system as a whole
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class Stats extends Command
{

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return 'stats';
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
     * @throws \Beanstalk\Exception  When any error occurs
     * @return \Beanstalk\Stats
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
        if (preg_match('/^OK (\d+)$/', $response, $matches)) {
            return new BeanstalkStats($data);
        }

        throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }
}
