<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk\Command;

use Beanstalk\Command;
use Beanstalk\Connection;
use Beanstalk\Exception;
use Beanstalk\Stats as BeanstalkStats;

/**
 * The stats-tube command gives statistical information about the specified tube if it exists
 */
class StatsTube extends Command
{

    protected $tube;

    /**
     * Constructor
     *
     * @param  string               $tube Stats will be returned for this tube.
     * @throws \Beanstalk\Exception When $tube exceeds 200 bytes
     */
    public function __construct($tube)
    {
        if (strlen($tube) > 200) {
            throw new Exception('Tube name must be at most 200 bytes', Exception::TUBE_NAME_TOO_LONG);
        }

        $this->tube = $tube;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('stats-tube %s', $this->tube);
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
     * @throws \Beanstalk\Exception  When the job does not exist
     * @throws \Beanstalk\Exception  When any other error occurs
     * @return \Beanstalk\Stats
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
        if (preg_match('/^OK (\d+)$/', $response, $matches)) {
            return new BeanstalkStats($data);
        }

        if ($response === 'NOT_FOUND') {
            throw new Exception('The tube does not exist.', Exception::NOT_FOUND);
        }

        throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }
}
