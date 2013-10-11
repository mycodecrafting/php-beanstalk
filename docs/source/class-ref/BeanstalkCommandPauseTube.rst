BeanstalkCommandPauseTube Class Ref
===================================

.. php:class:: BeanstalkCommandPauseTube

    :Extends: :php:class:`BeanstalkCommand`
    :Description: The pause-tube command can delay any new job being reserved for a given time
    :Author: Joshua Dechant <jdechant@shapeup.com>


.. topic:: Class Methods

    * :php:meth:`BeanstalkCommandPauseTube::__construct` -- Constructor
    * :php:meth:`BeanstalkCommandPauseTube::getCommand` -- Get the command to send to the beanstalkd server
    * :php:meth:`BeanstalkCommandPauseTube::parseResponse` -- Parse the response for success or failure.

.. php:method:: __construct( $tube , $delay )

    :Description: Constructor
    :param string $tube: The tube to pause
    :param integer $delay: Number of seconds to wait before reserving any more jobs from the queue

.. php:method:: getCommand(  )

    :Description: Get the command to send to the beanstalkd server
    :returns: *string*

.. php:method:: parseResponse( $response [ , $data = null , $conn = null ] )

    :Description: Parse the response for success or failure.
    :param string $response: Response line, i.e, first line in response
    :param string $data: Data recieved with reponse, if any, else null
    :param BeanstalkConnection $conn: BeanstalkConnection use to send the command
    :returns: *boolean* True if command was successful
    :throws: *BeanstalkException* When the tube does not exist
    :throws: *BeanstalkException* When any other error occurs


