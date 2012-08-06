<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * The list-tubes command returns a list of all existing tubes
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class BeanstalkCommandListTubes extends BeanstalkCommand
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
     * @param BeanstalkConnection $conn BeanstalkConnection use to send the command
     * @throws BeanstalkException When any error occurs
     * @return array List of all existing tubes
     */
    public function parseResponse($response, $data = null, BeanstalkConnection $conn = null)
    {
		if (preg_match('/^OK (\d+)$/', $response, $matches))
        {
            preg_match_all('/^\-\s+(.+)\r?$/Um', $data, $matches);
            return $matches[1];
        }

	    throw new BeanstalkException('An unknown error has occured.', BeanstalkException::UNKNOWN);
    }

}
