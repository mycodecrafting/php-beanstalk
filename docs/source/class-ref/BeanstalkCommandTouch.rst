BeanstalkCommandTouch Class Ref
===============================

.. php:class:: BeanstalkCommandTouch

    :Extends: :php:class:`BeanstalkCommand`
    :Description: Touch command
    :Author: Joshua Dechant <jdechant@shapeup.com>


    The "touch" command allows a worker to request more time to work on a job.
    This is useful for jobs that potentially take a long time, but you still want
    the benefits of a TTR pulling a job away from an unresponsive worker.  A worker
    may periodically tell the server that it's still alive and processing a job
    (e.g. it may do this on DEADLINE_SOON).

.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandTouch::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandTouch::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandTouch::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $id )

    :Description: Constructor
    :param integer $id: The job id to touch

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *boolean* True if command was successful
    :throws: *BeanstalkException* When the job cannot be found or has already timed out
    :throws: *BeanstalkException* When any other error occurs


