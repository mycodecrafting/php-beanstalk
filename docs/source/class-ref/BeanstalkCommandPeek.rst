BeanstalkCommandPeek Class Ref
==============================

.. php:class:: BeanstalkCommandPeek

    :Extends: :php:class:`BeanstalkCommand`
    :Description: The peek commands let the client inspect a job in the system
    :Author: Joshua Dechant <jdechant@shapeup.com>


    There are four variations. All but the first operate only on the currently used tube.
         - peek $id - return job $id
         - ready - return the next ready job
         - delayed - return the delayed job with the shortest delay left
         - buried - return the next job in the list of buried jobs

.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandPeek::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandPeek::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandPeek::parseResponse` -- Parse the response for success or failure.
    * :php:meth:`BeanstalkCommandPeek::returnsData` -- Does the command return data?

.. php:method:: __construct( $what )

    :Description: Constructor
    :param mixed $what: What to peek. One of job id, "ready", "delayed", or "buried"

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *BeanstalkJob*
    :throws: *BeanstalkException* When the job doesn't exist or there are no jobs in the requested state
    :throws: *BeanstalkException* When any other error occurs

.. php:method:: returnsData(  )

    :Description: Does the command return data?
    :returns: *boolean*


