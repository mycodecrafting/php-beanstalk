<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
namespace Beanstalk\Commands;
use \Beanstalk\Command;
use \Beanstalk\Connection;
use \Beanstalk\Exception;

/**
 * Use command
 *
 * The "use" command is for producers. Subsequent put commands will put jobs into
 * the tube specified by this command. If no use command has been issued, jobs
 * will be put into the tube named "default".
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class UseCommand extends Command
{

    protected $_tube;

    /**
     * Constructor
     *
     * @param string $tube The tube to use. If the tube does not exist, it will be created.
     * @throws Exception When $tube exceeds 200 bytes
     */
    public function __construct($tube)
    {
        if (strlen($tube) > 200)
        {
            throw new Exception('Tube name must be at most 200 bytes', Exception::TUBE_NAME_TOO_LONG);
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
        return sprintf('use %s', $this->_tube);
    }

    /**
     * Parse the response for success or failure.
     *
     * @param string $response Response line, i.e, first line in response
     * @param string $data Data recieved with reponse, if any, else null
     * @param Connection $conn Connection use to send the command
     * @throws Exception When any error occurs
     * @return string The name of the tube now being used
     */
    public function parseResponse($response, $data = null, Connection $conn = null)
    {
		if (preg_match('/^USING (.+)$/', $response, $matches))
		{
		    return $matches[1];
		}

	    throw new Exception('An unknown error has occured.', Exception::UNKNOWN);
    }

}
