<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Beanstalk;

/**
 * Beanstalkd connection pool
 *
 * <code>
 * $beanstalk = (new \Beanstalk\Pool)
 *     ->addServer('localhost', 11300)
 *     ->useTube('my-tube');
 * $beanstalk->put('Hello World!');
 * </code>
 *
 * @author Joshua Dechant <jdechant@shapeup.com>
 */
class Pool
{

    protected $addresses = [];
    protected $timeout = 500;
    protected $lastConnection = false;
    protected $connections = [];
    protected $streamClass = '\Beanstalk\Connection\Stream\Socket';

    protected $using = false;
    protected $watching = [];
    protected $ignoring = [];

    /**
     * Sets the stream class to use for the connections in the pool
     *
     * @param  string $class Name of stream class
     * @return self
     */
    public function setStream($class)
    {
        $this->streamClass = $class;
        return $this;
    }

    /**
     * Add a beanstalkd server to the pool
     *
     * @param  string  $host Server host
     * @param  integer $port Server port
     * @return self
     */
    public function addServer($host, $port = 11300)
    {
        $this->addresses[] = sprintf('%s:%s', $host, $port);
        return $this;
    }

    /**
     * Get the current connection timeout
     *
     * @return float Current connection timeout
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Set the connection timeout for attempting to connect to servers in the pool
     *
     * @param  float $timeout Connection timeout in milliseconds
     * @return self
     */
    public function setTimeout($timeout)
    {
        $this->timeout = (float) $timeout;

        return $this;
    }

    /**
     * @todo
     */
    public function getConnections()
    {
        try {
            $this->connect();
        } catch (Exception $e) {
        }

        return $this->connections;
    }

    public function getLastConnection()
    {
        if ($this->lastConnection !== false) {
            return $this->connections[$this->lastConnection];
        }

        return false;
    }

    /**
     * Get the Beanstalkd server addresses in the pool
     *
     * @return array Beanstalkd server addresses in the format "host:port"
     */
    public function getServers()
    {
        return $this->addresses;
    }

    /**
     * Establish a connection to all servers in the pool
     */
    public function connect()
    {
        // check for timed out servers and remove them from the connection pool
        foreach ($this->connections as $address => $conn) {
            if ($conn->isTimedOut()) {
                $conn->close();
                unset($this->connections[$address]);
            }
        }

        // attempt to connect/re-connect to any server not actively connected to
        foreach ($this->addresses as $address) {
            if (!isset($this->connections[$address])) {
                try {
                    $this->connections[$address] = new Connection(
                        $address,
                        new $this->streamClass,
                        $this->getTimeout()
                    );

                    // issue certain commands on (re)connection
                    foreach ($this->watching as $tube) {
                        $this->connections[$address]->watchTube($tube);
                    }

                    if ($this->using !== false) {
                        $this->connections[$address]->useTube($this->using);
                    }

                    foreach ($this->ignoring as $tube) {
                        $this->connections[$address]->ignoreTube($tube);
                    }

                // silently fail if a server is offline
                } catch (Exception $e) {
                    unset($this->connections[$address]);
                }
            }
        }

        // no connections!
        if (count($this->connections) === 0) {
            throw new Exception('Could not establish a connection to any beanstalkd server in the pool.');
        }
    }

    /**
     * Close all connections in the pool
     */
    public function close()
    {
        foreach ($this->connections as $conn) {
            $conn->close();
        }

        $this->using = false;
        $this->watching = array();
        $this->ignoring = array();
    }

    /**
     * The "put" command is for any process that wants to insert a job into the queue
     *
     * @param mixed   $message  Description
     * @param integer $priority Job priority.
     *                          Jobs with smaller priority values will be scheduled before jobs with larger priorities.
     *                          The most urgent priority is 0; the least urgent priority is 4,294,967,295.
     * @param integer $delay    Number of seconds to wait before putting the job in the ready queue.
     *                          The job will be in the "delayed" state during this time.
     * @param integer $ttr      Time to run. The number of seconds to allow a worker to run this job.
     *                          This time is counted from the moment a worker reserves this job.
     *                          If the worker does not delete, release, or bury the job within
     *                          <ttr> seconds, the job will time out and the server will release the job.
     *                          The minimum ttr is 1. If the client sends 0, the server will silently
     *                          increase the ttr to 1.
     */
    public function put($message, $priority = 65536, $delay = 0, $ttr = 120)
    {
        return $this->sendToRandomConnection('put', $message, $priority, $delay, $ttr);
    }

    /**
     * Use command
     *
     * The "use" command is for producers. Subsequent put commands will put jobs into
     * the tube specified by this command. If no use command has been issued, jobs
     * will be put into the tube named "default".
     *
     * @param  string $tube The tube to use. If the tube does not exist, it will be created.
     * @return self
     */
    public function useTube($tube)
    {
        $this->sendToAllConnections('useTube', $tube);
        $this->using = $tube;

        return $this;
    }

    /**
     * Watch command
     *
     * The "watch" command adds the named tube to the watch list for the connection
     * pool. A reserve command will take a job from any of the tubes in the
     * watch list. For each new connection, the watch list initially consists of one
     * tube, named "default".
     *
     * @param  string $tube Tube to add to the watch list. If the tube doesn't exist, it will be created
     * @return self
     */
    public function watchTube($tube)
    {
        $this->sendToAllConnections('watchTube', $tube);
        if (!in_array($tube, $this->watching)) {
            $this->watching[] = $tube;
        }

        return $this;
    }

    /**
     * Ignore command
     *
     * The "ignore" command is for consumers. It removes the named tube from the
     * watch list for the current connection.
     *
     * @param  string $tube Tube to remove from the watch list
     * @return self
     */
    public function ignoreTube($tube)
    {
        $this->sendToAllConnections('ignoreTube', $tube);
        if (!in_array($tube, $this->ignoring)) {
            $this->ignoring[] = $tube;
        }

        return $this;
    }

    /**
     * Reserve command
     *
     * This will return a newly-reserved job. If no job is available to be reserved,
     * beanstalkd will wait to send a response until one becomes available. Once a
     * job is reserved for the client, the client has limited time to run (TTR) the
     * job before the job times out. When the job times out, the server will put the
     * job back into the ready queue. Both the TTR and the actual time left can be
     * found in response to the stats-job command.
     *
     * A timeout value of 0 will cause the server to immediately return either a
     * response or TIMED_OUT.  A positive value of timeout will limit the amount of
     * time the client will block on the reserve request until a job becomes
     * available.
     *
     * @param integer $timeout Wait timeout in seconds
     */
    public function reserve($timeout = null)
    {
        return $this->sendToRandomConnection('reserve', $timeout);
    }

    /**
     * The stats command gives statistical information about the system as a whole
     */
    public function stats()
    {
        return $this->sendToAllConnections('stats');
    }

    /**
     * The list-tubes command returns a list of all existing tubes
     */
    public function listTubes()
    {
        return $this->mergeResponses($this->sendToAllConnections('listTubes'));
    }

    /**
     * The pause-tube command can delay any new job being reserved for a given time
     *
     * @param  string             $tube  The tube to pause
     * @param  integer            $delay Number of seconds to wait before reserving any more jobs from the queue
     * @throws \Beanstalk\Exception
     * @return boolean
     */
    public function pauseTube($tube, $delay)
    {
        $this->sendToAllConnections('pauseTube', $tube, $delay);

        return true;
    }

    /**
     * Kick command
     *
     * The kick command applies only to the currently used tube. It moves jobs into
     * the ready queue. If there are any buried jobs, it will only kick buried jobs.
     * Otherwise it will kick delayed jobs
     *
     * @param  integer $bound Upper bound on the number of jobs to kick. Each server will kick no more than $bound jobs.
     * @return integer The number of jobs actually kicked
     */
    public function kick($bound)
    {
        $results = $this->sendToAllConnections('kick', $bound);

        return array_sum($results);
    }

    protected function mergeResponses(array $responses)
    {
        $ret = array();
        foreach ($responses as $response) {
            $ret = array_merge($ret, $response);
        }

        return $ret;
    }

    /**
     * Sends the command to a random connection in the pool
     */
    protected function sendToRandomConnection($command)
    {
        $this->connect();

        $args = array();
        if (func_num_args() > 1) {
            $args = func_get_args();
            array_shift($args);
        }

        $i = $this->lastConnection = array_rand($this->connections);

        return call_user_func_array(array($this->connections[$i], $command), $args);
    }

    /**
     * Sends the command to all connections in the pool
     */
    protected function sendToAllConnections($command)
    {
        $this->connect();

        $args = array();
        if (func_num_args() > 1) {
            $args = func_get_args();
            array_shift($args);
        }

        $ret = array();
        foreach ($this->connections as $conn) {
            $ret[] = call_user_func_array(array($conn, $command), $args);
        }

        return $ret;
    }
}
