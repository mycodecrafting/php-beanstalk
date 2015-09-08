Beanstalk\\Command\\Reserve Class Ref
=====================================

.. php:namespace:: Beanstalk\Command

.. php:class:: Reserve

    :Extends: :php:class:`Beanstalk\\Command`
    :Description: Reserve command
    :Author: Joshua Dechant <jdechant@shapeup.com>


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

.. topic:: Class Methods

    * :php:meth:`Reserve::__construct` -- Constructor
    * :php:meth:`Reserve::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`Reserve::parseResponse` -- Parse the response for success or failure.
    * :php:meth:`Reserve::returnsData` -- Does the command return data?

.. php:method:: __construct( [ $timeout = null ] )

    :Description: Constructor
    :param integer $timeout: Wait timeout in seconds

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param Beanstalk\Connection $conn: BeanstalkConnection use to send the command
    :returns: *\Beanstalk\Job*
    :throws: *\Beanstalk\Exception* When trying to reserve another job and the TTR of the current job ends soon
    :throws: *\Beanstalk\Exception* When the wait timeout exceeded before a job became available
    :throws: *\Beanstalk\Exception* When any other error occurs

.. php:method:: returnsData(  )

    :Description: Does the command return data?
    :returns: *boolean*


