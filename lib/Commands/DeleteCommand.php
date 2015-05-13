<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Beanstalk\Commands;
use \Beanstalk\Command;
use \Beanstalk\Connection;
use \Beanstalk\Exception;

/**
 * Delete command
 *
 * The delete command removes a job from the server entirely. It is normally used
 * by the client when the job has successfully run to completion. A client can
 * delete jobs that it has reserved, ready jobs, and jobs that are buried.
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class DeleteCommand extends Command
{

    protected $_id = null;

    /**
     * Constructor
     *
     * @param integer $id The job id to delete
     */
    public function __construct($id)
    {
        $this->_id = $id;
    }

    /**
     * Get the delete command to send to the beanstalkd server
     *
     * @return string
     */
    public function getCommand()
    {
        return sprintf('delete %d', $this->_id);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data recieved with reponse, if any, else null
     * @param Connection $conn Connection use to send the command
     * @throws Exception When the job cannot be found or has already timed out
     * @throws Exception When any other error occurs
     * @return boolean True if command was successful
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
        if ($response === 'DELETED')
        {
            return true;
        }

        if ($response === 'NOT_FOUND')
        {
		    throw new Exception(
		        'The job does not exist or is not either reserved by the client, ready, or buried. ' .
		        'This could happen if the job timed out before the client sent the delete command.',
		        Exception::NOT_FOUND
            );
        }

	    throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }

}
