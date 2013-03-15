BeanstalkPool Class Ref
=======================

.. php:class:: BeanstalkPool

    Beanstalkd connection pool

.. topic:: Class Methods

    * :php:meth:`BeanstalkPool::addServer` -- Add a beanstalkd server to the pool
    * :php:meth:`BeanstalkPool::close` -- Close all connections in the pool
    * :php:meth:`BeanstalkPool::connect` -- Establish a connection to all servers in the pool
    * :php:meth:`BeanstalkPool::getConnections` -- @todo
    * :php:meth:`BeanstalkPool::getLastConnection`
    * :php:meth:`BeanstalkPool::getServers` -- Get the Beanstalkd server addresses in the pool
    * :php:meth:`BeanstalkPool::ignore` -- Ignore command
    * :php:meth:`BeanstalkPool::kick` -- Kick command
    * :php:meth:`BeanstalkPool::listTubes` -- The list-tubes command returns a list of all existing tubes
    * :php:meth:`BeanstalkPool::pauseTube` -- The pause-tube command can delay any new job being reserved for a given time
    * :php:meth:`BeanstalkPool::put` -- The "put" command is for any process that wants to insert a job into the queue
    * :php:meth:`BeanstalkPool::reserve` -- Reserve command
    * :php:meth:`BeanstalkPool::setStream`
    * :php:meth:`BeanstalkPool::stats` -- The stats command gives statistical information about the system as a whole
    * :php:meth:`BeanstalkPool::useTube` -- Use command
    * :php:meth:`BeanstalkPool::watch` -- Watch command

.. php:method:: addServer( $host [ , $port = 11300 ] )

    Add a beanstalkd server to the pool

    :param string $host: Server host
    :param integer $port: Server port

.. php:method:: close(  )

    Close all connections in the pool

.. php:method:: connect(  )

    Establish a connection to all servers in the pool

.. php:method:: getConnections(  )

    @todo

.. php:method:: getLastConnection(  )

.. php:method:: getServers(  )

    Get the Beanstalkd server addresses in the pool

    :returns: *array*  Beanstalkd server addresses in the format "host:port"

.. php:method:: ignore( $tube )

    Ignore command

    :param string $tube: Tube to remove from the watch list

    The "ignore" command is for consumers. It removes the named tube from the
    watch list for the current connection.

.. php:method:: kick( $bound )

    Kick command

    :param integer $bound: Upper bound on the number of jobs to kick. Each server will kick no more than $bound jobs.
    :returns: *integer*  The number of jobs actually kicked

    The kick command applies only to the currently used tube. It moves jobs into
    the ready queue. If there are any buried jobs, it will only kick buried jobs.
    Otherwise it will kick delayed jobs

.. php:method:: listTubes(  )

    The list-tubes command returns a list of all existing tubes

.. php:method:: pauseTube( $tube , $delay )

    The pause-tube command can delay any new job being reserved for a given time

    :param string $tube: The tube to pause
    :param integer $delay: Number of seconds to wait before reserving any more jobs from the queue
    :returns: *boolean*
    :throws: *BeanstalkException*

.. php:method:: put( $message [ , $priority = 65536 , $delay = 0 , $ttr = 120 ] )

    The "put" command is for any process that wants to insert a job into the queue

    :param mixed $message: Description
    :param integer $priority: Job priority.
    :param integer $delay: Number of seconds to wait before putting the job in the ready queue.
    :param integer $ttr: Time to run. The number of seconds to allow a worker to run this job.

.. php:method:: reserve( [ $timeout = null ] )

    Reserve command

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

    :param mixed $class:

.. php:method:: stats(  )

    The stats command gives statistical information about the system as a whole

.. php:method:: useTube( $tube )

    Use command

    :param string $tube: The tube to use. If the tube does not exist, it will be created.

    The "use" command is for producers. Subsequent put commands will put jobs into
    the tube specified by this command. If no use command has been issued, jobs
    will be put into the tube named "default".

.. php:method:: watch( $tube )

    Watch command

    :param string $tube: Tube to add to the watch list. If the tube doesn't exist, it will be created

    The "watch" command adds the named tube to the watch list for the connection
    pool. A reserve command will take a job from any of the tubes in the
    watch list. For each new connection, the watch list initially consists of one
    tube, named "default".
