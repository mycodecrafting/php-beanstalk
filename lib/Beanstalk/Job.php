<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */


/**
 * A Beanstalkd job
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class BeanstalkJob
{

    /**
     * Constructor
     *
     * @param BeanstalkConnection $conn BeanstalkConnection for the job
     * @param integer $id Job id
     * @param string $message Job body. If the body is JSON, it will be converted to an object
     */
    public function __construct(BeanstalkConnection $conn, $id, $message)
    {
        $this->_conn = $conn;
        $this->_id = $id;
        if (($msg = json_decode($message)) === null)
        {
            $msg = $message;
        }
        $this->_message = $msg;
    }

    /**
     * Get the job id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Get the job body/message
     *
     * @return mixed String of body for simple message; stdClass for JSON messages
     */
    public function getMessage()
    {
        return $this->_message;
    }

    /**
     * Get the beanstalkd connection for the job
     *
     * @return BeanstalkConnection
     */
    public function getConnection()
    {
        return $this->_conn;
    }

    /**
     * Delete the job
     *
     * The delete command removes a job from the server entirely. It is normally used
     * by the client when the job has successfully run to completion.
     *
     * @throws BeanstalkException
     * @return boolean
     */
    public function delete()
    {
        return $this->getConnection()->delete($this->getId());
    }

    /**
     * Touch the job
     *
     * The "touch" command allows a worker to request more time to work on a job.
     * This is useful for jobs that potentially take a long time, but you still want
     * the benefits of a TTR pulling a job away from an unresponsive worker.  A worker
     * may periodically tell the server that it's still alive and processing a job
     * (e.g. it may do this on DEADLINE_SOON).
     *
     * @throws BeanstalkException
     * @return boolean
     */
    public function touch()
    {
        return $this->getConnection()->touch($this->getId());
    }

    /**
     * Release the job
     *
     * The release command puts a reserved job back into the ready queue (and marks
     * its state as "ready") to be run by any client. It is normally used when the job
     * fails because of a transitory error.
     *
     * @param integer $delay Number of seconds to wait before putting the job in the ready queue. The job will be in the "delayed" state during this time
     * @param integer $priority A new priority to assign to the job
     * @throws BeanstalkException
     * @return boolean
     */
    public function release($delay = 10, $priority = 5)
    {
        return $this->getConnection()->release($this->getId(), $priority, $delay);
    }

    /**
     * Bury the job
     *
     * The bury command puts a job into the "buried" state. Buried jobs are put into a
     * FIFO linked list and will not be touched by the server again until a client
     * kicks them with the "kick" command.
     *
     * @param integer $priority A new priority to assign to the job
     */
    public function bury($priority = 2048)
    {
        return $this->getConnection()->bury($this->getId(), $priority);
    }

    /**
     * Get stats on the job
     *
     * The stats-job command gives statistical information about the specified job if
     * it exists.
     *
     * @throws BeanstalkException When the job does not exist
     * @return BeanstalkStats
     */
    public function stats()
    {
        return $this->getConnection()->statsJob($this->getId());
    }

}
