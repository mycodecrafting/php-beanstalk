<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * Beanstalk Exceptions
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class BeanstalkException extends Exception
{

    /**
     * @const The server cannot allocate enough memory for the job. The client should try again later.
     */
    const OUT_OF_MEMORY         = 5001;

    /**
     * @const This indicates a bug in the server. It should never happen. If it does happen, please report it at http://groups.google.com/group/beanstalk-talk.
     */
    const INTERNAL_ERROR        = 5002;

    /**
     * @const The client sent a command line that was not well-formed
     */
    const BAD_FORMAT            = 5003;

    /**
     * @const The client sent a command that the server does not know
     */
    const UNKNOWN_COMMAND       = 5004;

    /**
     * @const Buried error (usually occurs when server runs out of memory)
     */
    const BURIED                = 5050;

    /**
     * @const Not Found error
     */
    const NOT_FOUND             = 5051;

    /**
     * @const Expected to find a CRLF "\r\n" but did not
     */
    const EXPECTED_CRLF         = 5052;

    /**
     * @const Job body exceeds max-job-size in bytes
     */
    const JOB_TOO_BIG           = 5053;

    /**
     * @const Job TTR ends soon (< 1 second)
     */
    const DEADLINE_SOON         = 5054;

    /**
     * @const The wait timeout exceeded before a job became available
     */
    const TIMED_OUT             = 5055;

    /**
     * @const Tube name specified exceeds 200 bytes
     */
    const TUBE_NAME_TOO_LONG    = 5056;

    /**
     * @const The client attempted to ignore the only tube in its watch list
     */
    const NOT_IGNORED           = 5057;

    /**
     * @const Generic unknown error
     */
    const UNKNOWN               = 5096;

    /**
     * @const The server appears to be offline
     */
    const SERVER_OFFLINE        = 6001;

    /**
     * @const There was an error reading from the server
     */
    const SERVER_READ           = 6050;

    /**
     * @const There was an error writing to the server (broken pipe?)
     */
    const SERVER_WRITE          = 6051;

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        $this->code = $code;
        $message = sprintf('%s: %s', $this->getCodeAsString(), $message);
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get a string representation of a given code
     *
     * @param integer $code Code to get string representation of
     * @return string
     */
    public function getCodeAsString()
    {
        switch ($this->getCode())
        {
            case self::BURIED:              return 'Buried';
            case self::NOT_FOUND:           return 'Not Found';
            case self::EXPECTED_CRLF:       return 'Expected CRLF';
            case self::JOB_TOO_BIG:         return 'Job Too Big';
            case self::DEADLINE_SOON:       return 'Deadline Soon';
            case self::TIMED_OUT:           return 'Timed Out';
            case self::TUBE_NAME_TOO_LONG:  return 'Tube Name Too Long';
            case self::NOT_IGNORED:         return 'Not Ignored';
            case self::OUT_OF_MEMORY:       return 'Out of Memory';
            case self::INTERNAL_ERROR:      return 'Internal Error';
            case self::BAD_FORMAT:          return 'Bad Format';
            case self::UNKNOWN_COMMAND:     return 'Unknown Command';
            case self::SERVER_OFFLINE:      return 'Server Offline';
            case self::SERVER_READ:         return 'Server Read Error';
            case self::SERVER_WRITE:        return 'Server Write Error';
            default:                        return 'Unknown';
        }
    }

}
