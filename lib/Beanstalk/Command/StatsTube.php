<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * The stats-tube command gives statistical information about the specified tube if it exists
 */
class BeanstalkCommandStatsTube extends BeanstalkCommand
{

    protected $_tube;

    /**
     * Constructor
     *
     * @param string $tube Stats will be returned for this tube.
     * @throws BeanstalkException When $tube exceeds 200 bytes
     */
    public function __construct($tube)
    {
        if (strlen($tube) > 200)
        {
            throw new BeanstalkException('Tube name must be at most 200 bytes', BeanstalkException::TUBE_NAME_TOO_LONG);
        }

        $this->_tube = $tube;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('stats-tube %s', $this->_tube);
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
     * @throws BeanstalkException When the job does not exist
     * @throws BeanstalkException When any other error occurs
     * @return BeanstalkStats
     */
    public function parseResponse($response, $data = null, BeanstalkConnection $conn = null)
    {
		if (preg_match('/^OK (\d+)$/', $response, $matches))
        {
            return new BeanstalkStats($data);
        }

        if ($response === 'NOT_FOUND')
        {
            throw new BeanstalkException('The tube does not exist.', BeanstalkException::NOT_FOUND);
        }

	    throw new BeanstalkException('An unknown error has occured.', BeanstalkException::UNKNOWN);
    }

}
