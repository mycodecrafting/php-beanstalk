<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * The pause-tube command can delay any new job being reserved for a given time
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class BeanstalkCommandPauseTube extends BeanstalkCommand
{

    protected $_tube;
    protected $_delay;

    /**
     * Constructor
     *
     * @param string $tube The tube to pause
     * @param integer $delay Number of seconds to wait before reserving any more jobs from the queue
     */
    public function __construct($tube, $delay)
    {
        $this->_tube = $tube;
        $this->_delay = $delay;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('pause-tube %s %d', $this->_tube, $this->_delay);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data recieved with reponse, if any, else null
     * @param BeanstalkConnection $conn BeanstalkConnection use to send the command
     * @throws BeanstalkException When the tube does not exist
     * @throws BeanstalkException When any other error occurs
     * @return boolean True if command was successful
     */
    public function parseResponse($response, $data = null, BeanstalkConnection $conn = null)
    {
        if ($response === 'PAUSED')
        {
            return true;
        }

        if ($response === 'NOT_FOUND')
        {
            throw new BeanstalkException('The tube does not exist.', BeanstalkException::NOT_FOUND);
        }

	    throw new BeanstalkException('An unknown error has occured.', BeanstalkException::UNKNOWN);
    }

}
