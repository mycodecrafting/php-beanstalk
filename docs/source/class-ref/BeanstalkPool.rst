BeanstalkPool Class Ref
=======================

.. php:class:: BeanstalkPool

    :Description: Beanstalkd connection pool
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Methods

    * :php:meth:`BeanstalkPool::addServer` -- Add a beanstalkd server to the pool
    * :php:meth:`BeanstalkPool::close` -- Close all connections in the pool
    * :php:meth:`BeanstalkPool::connect` -- Establish a connection to all servers in the pool
    * :php:meth:`BeanstalkPool::getConnections`
    * :php:meth:`BeanstalkPool::getLastConnection`
    * :php:meth:`BeanstalkPool::getServers` -- Get the Beanstalkd server addresses in the pool
    * :php:meth:`BeanstalkPool::getTimeout` -- Get the current connection timeout
    * :php:meth:`BeanstalkPool::ignore` -- Ignore command
    * :php:meth:`BeanstalkPool::kick` -- Kick command
    * :php:meth:`BeanstalkPool::listTubes` -- The list-tubes command returns a list of all existing tubes
    * :php:meth:`BeanstalkPool::pauseTube` -- The pause-tube command can delay any new job being reserved for a given time
    * :php:meth:`BeanstalkPool::put` -- The "put" command is for any process that wants to insert a job into the queue
    * :php:meth:`BeanstalkPool::reserve` -- Reserve command
    * :php:meth:`BeanstalkPool::setStream` -- Sets the stream class to use for the connections in the pool
    * :php:meth:`BeanstalkPool::setTimeout` -- Set the connection timeout for attempting to connect to servers in the pool
    * :php:meth:`BeanstalkPool::stats` -- The stats command gives statistical information about the system as a whole
    * :php:meth:`BeanstalkPool::useTube` -- Use command
    * :php:meth:`BeanstalkPool::watch` -- Watch command

.. php:method:: addServer( $host [ , $port = 11300 ] )

    :Description: Add a beanstalkd server to the pool
    :param string $host: Server host
    :param integer $port: Server port
    :returns: *self*

.. php:method:: close(  )

    :Description: Close all connections in the pool

.. php:method:: connect(  )

    :Description: Establish a connection to all servers in the pool

.. php:method:: getConnections(  )

    .. todo:: */

.. php:method:: getLastConnection(  )

.. php:method:: getServers(  )

    :Description: Get the Beanstalkd server addresses in the pool
    :returns: *array* Beanstalkd server addresses in the format "host:port"

.. php:method:: getTimeout(  )

    :Description: Get the current connection timeout
    :returns: *float* Current connection timeout

.. php:method:: ignore( $tube )

    :Description: Ignore command
    :param string $tube: Tube to remove from the watch list
    :returns: *self*

    The "ignore" command is for consumers. It removes the named tube from the
    watch list for the current connection.

.. php:method:: kick( $bound )

    :Description: Kick command
    :param integer $bound: Upper bound on the number of jobs to kick. Each server will kick no more than $bound jobs.
    :returns: *integer* The number of jobs actually kicked

    The kick command applies only to the currently used tube. It moves jobs into
    the ready queue. If there are any buried jobs, it will only kick buried jobs.
    Otherwise it will kick delayed jobs

.. php:method:: listTubes(  )

    :Description: The list-tubes command returns a list of all existing tubes

.. php:method:: pauseTube( $tube , $delay )

    :Description: The pause-tube command can delay any new job being reserved for a given time
    :param string $tube: The tube to pause
    :param integer $delay: Number of seconds to wait before reserving any more jobs from the queue
    :returns: *boolean*
    :throws: *BeanstalkException*

.. php:method:: put( $message [ , $priority = 65536 , $delay = 0 , $ttr = 120 ] )

    :Description: The "put" command is for any process that wants to insert a job into the queue
    :param mixed $message: Description
    :param integer $priority: Job priority.
    :param integer $delay: Number of seconds to wait before putting the job in the ready queue.
    :param integer $ttr: Time to run. The number of seconds to allow a worker to run this job.

.. php:method:: reserve( [ $timeout = null ] )

    :Description: Reserve command
    :param integer $timeout: Wait timeout in seconds

    This will return a newly-reserved job. If no job is available to be reserved,
    beanstalkd will wait to send a response until one becomes available. Once a
    job is reserved for the client, the client has limited time to run (TTR) the
    job before the job times out. When the job times out, the server will put the
    job back into the ready queue. Both the TTR and the actual time left can be
    found in response to the stats-job command.

    A timeout value of 0 will cause the server to immediately return either a
    response or TIMED_OUT.  A positive value of timeout will limit the amount of
    time the client will block on the reserve request until a job becomes
    available.

.. php:method:: setStream( $class )

    :Description: Sets the stream class to use for the connections in the pool
    :param string $class: Name of stream class
    :returns: *self*

.. php:method:: setTimeout( $timeout )

    :Description: Set the connection timeout for attempting to connect to servers in the pool
    :param float $timeout: Connection timeout in milliseconds
    :returns: *self*

.. php:method:: stats(  )

    :Description: The stats command gives statistical information about the system as a whole

.. php:method:: useTube( $tube )

    :Description: Use command
    :param string $tube: The tube to use. If the tube does not exist, it will be created.
    :returns: *self*

    The "use" command is for producers. Subsequent put commands will put jobs into
    the tube specified by this command. If no use command has been issued, jobs
    will be put into the tube named "default".

.. php:method:: watch( $tube )

    :Description: Watch command
    :param string $tube: Tube to add to the watch list. If the tube doesn't exist, it will be created
    :returns: *self*

    The "watch" command adds the named tube to the watch list for the connection
    pool. A reserve command will take a job from any of the tubes in the
    watch list. For each new connection, the watch list initially consists of one
    tube, named "default".


