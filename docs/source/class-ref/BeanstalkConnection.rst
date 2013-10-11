BeanstalkConnection Class Ref
=============================

.. php:class:: BeanstalkConnection

    :Description: Beanstalkd connection
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Methods

    * :php:meth:`BeanstalkConnection::__construct` -- Constructor; establishes connection stream
    * :php:meth:`BeanstalkConnection::bury` -- Bury command
    * :php:meth:`BeanstalkConnection::close` -- Close the connection
    * :php:meth:`BeanstalkConnection::connect` -- Connect to the beanstalkd server
    * :php:meth:`BeanstalkConnection::delete` -- Delete command
    * :php:meth:`BeanstalkConnection::getServer` -- Get the Beanstalkd server address
    * :php:meth:`BeanstalkConnection::getStream` -- Get the connect's stream
    * :php:meth:`BeanstalkConnection::getTimeout` -- Get the connection timeout
    * :php:meth:`BeanstalkConnection::ignoreTube` -- Ignore command
    * :php:meth:`BeanstalkConnection::isTimedOut` -- Has the connection timed out?
    * :php:meth:`BeanstalkConnection::kick` -- Kick command
    * :php:meth:`BeanstalkConnection::listTubes` -- The list-tubes command returns a list of all existing tubes
    * :php:meth:`BeanstalkConnection::pauseTube` -- The pause-tube command can delay any new job being reserved for a given time
    * :php:meth:`BeanstalkConnection::peek` -- Return job $id
    * :php:meth:`BeanstalkConnection::peekBuried` -- Return the next job in the list of buried jobs
    * :php:meth:`BeanstalkConnection::peekDelayed` -- Return the delayed job with the shortest delay left
    * :php:meth:`BeanstalkConnection::peekReady` -- Return the next ready job
    * :php:meth:`BeanstalkConnection::put` -- The "put" command is for any process that wants to insert a job into the queue
    * :php:meth:`BeanstalkConnection::release` -- Release command
    * :php:meth:`BeanstalkConnection::reserve` -- Reserve command
    * :php:meth:`BeanstalkConnection::setTimeout` -- Set the connection timeout
    * :php:meth:`BeanstalkConnection::stats` -- The stats command gives statistical information about the system as a whole.
    * :php:meth:`BeanstalkConnection::statsJob` -- The stats-job command gives statistical information about the specified job if it exists.
    * :php:meth:`BeanstalkConnection::statsTube` -- The stats-tube command gives statistical information about the specified tube if it exists.
    * :php:meth:`BeanstalkConnection::touch` -- Touch command
    * :php:meth:`BeanstalkConnection::useTube` -- Use command
    * :php:meth:`BeanstalkConnection::validateResponse` -- Generic validation for all responses from beanstalkd
    * :php:meth:`BeanstalkConnection::watchTube` -- Watch command

.. php:method:: __construct( $address , $stream [ , $timeout = 500 ] )

    :Description: Constructor; establishes connection stream
    :param string $address: Beanstalkd server address in the format "host:port"
    :param BeanstalkConnectionStream $stream: Stream to use for connection
    :param float $timeout: Connection timeout in milliseconds
    :throws: *BeanstalkException* When a connection cannot be established

.. php:method:: bury( $id , $priority )

    :Description: Bury command
    :param integer $id: The job id to bury
    :param integer $priority: A new priority to assign to the job

    The bury command puts a job into the "buried" state. Buried jobs are put into a
    FIFO linked list and will not be touched by the server again until a client
    kicks them with the "kick" command.

.. php:method:: close(  )

    :Description: Close the connection

.. php:method:: connect(  )

    :Description: Connect to the beanstalkd server
    :returns: *boolean*
    :throws: *BeanstalkException* When a connection cannot be established

.. php:method:: delete( $id )

    :Description: Delete command
    :param integer $id: The job id to delete
    :returns: *boolean*
    :throws: *BeanstalkException*

    The delete command removes a job from the server entirely. It is normally used
    by the client when the job has successfully run to completion. A client can
    delete jobs that it has reserved, ready jobs, and jobs that are buried.

.. php:method:: getServer(  )

    :Description: Get the Beanstalkd server address
    :returns: *string* Beanstalkd server address in the format "host:port"

.. php:method:: getStream(  )

    :Description: Get the connect's stream
    :returns: *BeanstalkConnectionStream*

.. php:method:: getTimeout(  )

    :Description: Get the connection timeout
    :returns: *float* Connection timeout

.. php:method:: ignoreTube( $tube )

    :Description: Ignore command
    :param string $tube: Tube to remove from the watch list

    The "ignore" command is for consumers. It removes the named tube from the
    watch list for the current connection.

.. php:method:: isTimedOut(  )

    :Description: Has the connection timed out?
    :returns: *boolean*

.. php:method:: kick( $bound )

    :Description: Kick command
    :param integer $bound: Upper bound on the number of jobs to kick. The server will kick no more than $bound jobs.
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

.. php:method:: peek( $id )

    :Description: Return job $id
    :param integer $id: Id of job to return
    :returns: *BeanstalkJob*
    :throws: *BeanstalkException* When job cannot be found

.. php:method:: peekBuried(  )

    :Description: Return the next job in the list of buried jobs
    :returns: *BeanstalkJob*
    :throws: *BeanstalkException* When no jobs in buried state

.. php:method:: peekDelayed(  )

    :Description: Return the delayed job with the shortest delay left
    :returns: *BeanstalkJob*
    :throws: *BeanstalkException* When no jobs in delayed state

.. php:method:: peekReady(  )

    :Description: Return the next ready job
    :returns: *BeanstalkJob*
    :throws: *BeanstalkException* When no jobs in ready state

.. php:method:: put( $message [ , $priority = 65536 , $delay = 0 , $ttr = 120 ] )

    :Description: The "put" command is for any process that wants to insert a job into the queue
    :param mixed $message: Description
    :param integer $priority: Job priority.
    :param integer $delay: Number of seconds to wait before putting the job in the ready queue.
    :param integer $ttr: Time to run. The number of seconds to allow a worker to run this job.

.. php:method:: release( $id , $priority , $delay )

    :Description: Release command
    :param integer $id: The job id to release
    :param integer $priority: A new priority to assign to the job
    :param integer $delay: Number of seconds to wait before putting the job in the ready queue. The job will be in the "delayed" state during this time

    The release command puts a reserved job back into the ready queue (and marks
    its state as "ready") to be run by any client. It is normally used when the job
    fails because of a transitory error.

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

.. php:method:: setTimeout( $timeout )

    :Description: Set the connection timeout
    :param float $timeout: Connection timeout in milliseconds

.. php:method:: stats(  )

    :Description: The stats command gives statistical information about the system as a whole.

.. php:method:: statsJob( $id )

    :Description: The stats-job command gives statistical information about the specified job if it exists.
    :param integer $id: The job id to get stats on
    :returns: *BeanstalkStats*
    :throws: *BeanstalkException* When the job does not exist

.. php:method:: statsTube( $tube )

    :Description: The stats-tube command gives statistical information about the specified tube if it exists.
    :param string $tube: is a name at most 200 bytes. Stats will be returned for this tube.
    :returns: *BeanstalkStats*
    :throws: *BeanstalkException* When the tube does not exist

.. php:method:: touch( $id )

    :Description: Touch command
    :param integer $id: The job id to touch
    :returns: *boolean*
    :throws: *BeanstalkException*

    The "touch" command allows a worker to request more time to work on a job.
    This is useful for jobs that potentially take a long time, but you still want
    the benefits of a TTR pulling a job away from an unresponsive worker.  A worker
    may periodically tell the server that it's still alive and processing a job
    (e.g. it may do this on DEADLINE_SOON).

.. php:method:: useTube( $tube )

    :Description: Use command
    :param string $tube: The tube to use. If the tube does not exist, it will be created.

    The "use" command is for producers. Subsequent put commands will put jobs into
    the tube specified by this command. If no use command has been issued, jobs
    will be put into the tube named "default".

.. php:method:: validateResponse( $response )

    :Description: Generic validation for all responses from beanstalkd
    :param string $response: 
    :returns: *boolean* true when response is valid
    :throws: *BeanstalkException* When response is invalid

.. php:method:: watchTube( $tube )

    :Description: Watch command
    :param string $tube: Tube to add to the watch list. If the tube doesn't exist, it will be created

    The "watch" command adds the named tube to the watch list for the current
    connection. A reserve command will take a job from any of the tubes in the
    watch list. For each new connection, the watch list initially consists of one
    tube, named "default".


