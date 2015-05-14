Beanstalk\\Command\\StatsJob Class Ref
======================================

.. php:namespace:: Beanstalk\Command

.. php:class:: StatsJob

    :Extends: :php:class:`Beanstalk\\Command`
    :Description: The stats-job command gives statistical information about the specified job if it exists
    :Author: Joshua Dechant <jdechant@shapeup.com>


    Returned stats available:
      - id:              The job id
      - tube:            The name of the tube that contains this job
      - state:           One of "ready" or "delayed" or "reserved" or "buried"
      - pri:             The priority value set by the put, release, or bury commands.
      - age:             The time in seconds since the put command that created this job.
      - time-left:       The number of seconds left until the server puts this job
                         into the ready queue. This number is only meaningful if the job is
                         reserved or delayed. If the job is reserved and this amount of time
                         elapses before its state changes, it is considered to have timed out.
      - reserves:        The number of times this job has been reserved.
      - timeouts:        The number of times this job has timed out during a reservation.
      - releases:        The number of times a client has released this job from a reservation.
      - buries           The number of times this job has been buried.
      - kicks:           The number of times this job has been kicked.

.. topic:: Class Methods

    * :php:meth:`StatsJob::__construct` -- Constructor
    * :php:meth:`StatsJob::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`StatsJob::parseResponse` -- Parse the response for success or failure.
    * :php:meth:`StatsJob::returnsData` -- Does the command return data?

.. php:method:: __construct( $id )

    :Description: Constructor
    :param integer $id: Job id

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param Beanstalk\Connection $conn: BeanstalkConnection use to send the command
    :returns: *\Beanstalk\Stats*
    :throws: *\Beanstalk\Exception* When the job does not exist
    :throws: *\Beanstalk\Exception* When any other error occurs

.. php:method:: returnsData(  )

    :Description: Does the command return data?
    :returns: *boolean*


