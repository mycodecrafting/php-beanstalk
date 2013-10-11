BeanstalkCommandKick Class Ref
==============================

.. php:class:: BeanstalkCommandKick

    :Extends: :php:class:`BeanstalkCommand`
    :Description: Kick command
    :Author: Joshua Dechant <jdechant@shapeup.com>


    The kick command applies only to the currently used tube. It moves jobs into
    the ready queue. If there are any buried jobs, it will only kick buried jobs.
    Otherwise it will kick delayed jobs

.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandKick::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandKick::getCommand` -- Get the delete command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandKick::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $bound )

    :Description: Constructor
    :param integer $bound: Upper bound on the number of jobs to kick. The server will kick no more than $bound jobs.

.. php:method:: getCommand(  )

    :Description: Get the delete command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *integer* The number of jobs actually kicked
    :throws: *BeanstalkException* When any error occurs


