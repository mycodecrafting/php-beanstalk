Beanstalk\\Job Class Ref
========================

.. php:namespace:: Beanstalk

.. php:class:: Job

    :Description: A Beanstalkd job
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Methods

    * :php:meth:`Job::__construct` -- Constructor
    * :php:meth:`Job::bury` -- Bury the job
    * :php:meth:`Job::delete` -- Delete the job
    * :php:meth:`Job::getConnection` -- Get the beanstalkd connection for the job
    * :php:meth:`Job::getId` -- Get the job id
    * :php:meth:`Job::getMessage` -- Get the job body/message
    * :php:meth:`Job::release` -- Release the job
    * :php:meth:`Job::stats` -- Get stats on the job
    * :php:meth:`Job::touch` -- Touch the job

.. php:method:: __construct( $conn , $id , $message )

    :Description: Constructor
    :param Beanstalk\Connection $conn: Connection for the job
    :param integer $id: Job id
    :param string $message: Job body. If the body is JSON, it will be converted to an object

.. php:method:: bury( [ $priority = 2048 ] )

    :Description: Bury the job
    :param integer $priority: A new priority to assign to the job

    The bury command puts a job into the "buried" state. Buried jobs are put into a
    FIFO linked list and will not be touched by the server again until a client
    kicks them with the "kick" command.

.. php:method:: delete(  )

    :Description: Delete the job
    :returns: *boolean*
    :throws: *BeanstalkException*

    The delete command removes a job from the server entirely. It is normally used
    by the client when the job has successfully run to completion.

.. php:method:: getConnection(  )

    :Description: Get the beanstalkd connection for the job
    :returns: *BeanstalkConnection*

.. php:method:: getId(  )

    :Description: Get the job id
    :returns: *integer*

.. php:method:: getMessage(  )

    :Description: Get the job body/message
    :returns: *mixed* String of body for simple message; stdClass for JSON messages

.. php:method:: release( [ $delay = 10 , $priority = 5 ] )

    :Description: Release the job
    :param integer $delay: Number of seconds to wait before putting the job in the ready queue.
    :param integer $priority: A new priority to assign to the job
    :returns: *boolean*
    :throws: *BeanstalkException*

    The release command puts a reserved job back into the ready queue (and marks
    its state as "ready") to be run by any client. It is normally used when the job
    fails because of a transitory error.

.. php:method:: stats(  )

    :Description: Get stats on the job
    :returns: *BeanstalkStats*
    :throws: *BeanstalkException* When the job does not exist

    The stats-job command gives statistical information about the specified job if
    it exists.

.. php:method:: touch(  )

    :Description: Touch the job
    :returns: *boolean*
    :throws: *BeanstalkException*

    The "touch" command allows a worker to request more time to work on a job.
    This is useful for jobs that potentially take a long time, but you still want
    the benefits of a TTR pulling a job away from an unresponsive worker.  A worker
    may periodically tell the server that it's still alive and processing a job
    (e.g. it may do this on DEADLINE_SOON).


