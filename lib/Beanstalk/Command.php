<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * Abstract beanstalk command.
 *
 * All commands must extends this class
 *
 * @abstract
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
abstract class BeanstalkCommand
{

    /**
     * Get data, if any, to send with the command.
     *
     * Not all commands have data; in fact, most do not.
     *
     * @return mixed Data string to send with command or boolean false if none
     */
    public function getData()
    {
        return false;
    }

    /**
     * Does the command return data?
     *
     * @return boolean
     */
    public function returnsData()
    {
        return false;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    abstract public function getCommand();

    /**
     * Parse the response for success or failure.
     *
     * Failures should throw a BeanstalkException with the error message.
     *
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data recieved with reponse, if any, else null
     * @param BeanstalkConnection $conn BeanstalkConnection use to send the command
     * @throws BeanstalkException On failure
     * @return mixed On success
     */
    abstract public function parseResponse($response, $data = null, BeanstalkConnection $conn = null);

}
