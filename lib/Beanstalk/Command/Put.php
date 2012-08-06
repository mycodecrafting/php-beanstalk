<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * The "put" command is for any process that wants to insert a job into the queue
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class BeanstalkCommandPut extends BeanstalkCommand
{

    /**
     * Constructor
     *
     * @param mixed $message Message to put in the beanstalkd queue
     * @param integer $priority Job priority.
     *        Jobs with smaller priority values will be scheduled before jobs with larger priorities.
     *        The most urgent priority is 0; the least urgent priority is 4,294,967,295.
     * @param integer $delay Number of seconds to wait before putting the job in the ready queue.
     *        The job will be in the "delayed" state during this time.
     * @param integer $ttr Time to run. The number of seconds to allow a worker to run this job.
     *        This time is counted from the moment a worker reserves this job.
     *        If the worker does not delete, release, or bury the job within
     *        <ttr> seconds, the job will time out and the server will release the job.
     *        The minimum ttr is 1. If the client sends 0, the server will silently
     *        increase the ttr to 1.
     */
    public function __construct($message, $priority = 65536, $delay = 0, $ttr = 120)
    {
        if (is_object($message))
        {
            $message = json_encode($message);
        }

        $this->_message = $message;
        $this->_priority = $priority;
        $this->_delay = $delay;
        $this->_ttr = $ttr;
    }

    /**
     * Get the command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf(
            "put %d %d %d %d",
            $this->_priority,
            $this->_delay,
            $this->_ttr,
            strlen($this->_message)
        );
    }

    /**
     * Get the data to send to the beanstalkd server with the command
     *
     * @return string
     */
    public function getData()
    {
        return $this->_message;
    }

    /**
     * Parse the response for success or failure.
     *
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data recieved with reponse, if any, else null
     * @param BeanstalkConnection $conn BeanstalkConnection use to send the command
     * @throws BeanstalkException When the server runs out of memory
     * @throws BeanstalkException When the job body is malformed
     * @throws BeanstalkException When the job body is larger than max-job-size in the server
     * @throws BeanstalkException When any other error occurs
     * @return integer Id of the inserted job
     */
    public function parseResponse($response, $data = null, BeanstalkConnection $conn = null)
    {
		if (preg_match('/^INSERTED (\d+)$/', $response, $matches))
		{
		    return intval($matches[1]);
		}

        if (preg_match('/^BURIED (\d+)$/', $response, $matches))
		{
            throw new BeanstalkException(
                'The server ran out of memory trying to grow the priority queue data structure.', BeanstalkException::BURIED
            );
		}

        if ($response === 'EXPECTED_CRLF')
		{
		    throw new BeanstalkException(
		        'The job body must be followed by a CR-LF pair, that is, "\r\n". These two bytes are not counted in the job ' .
		        'size given by the client in the put command line.',
		        BeanstalkException::EXPECTED_CRLF
		    );
		}

        if ($response === 'JOB_TOO_BIG')
		{
		    throw new BeanstalkException(
		        'The client has requested to put a job with a body larger than max-job-size bytes.', BeanstalkException::JOB_TOO_BIG
		    );
		}

	    throw new BeanstalkException('An unknown error has occured.', BeanstalkException::UNKNOWN);
    }

}
